<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreComplexProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateComplexProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductQuality;
use App\Navigation\SuperAdminPath;
use App\Services\Core\ProductService;
use App\Services\File\FileUploadService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductsController extends BaseController
{
    public function __construct(
        private ProductService $productService,
        FileUploadService $fileUploadService
    ) {
        parent::__construct($fileUploadService);
    }

    public function index()
    {
        $query = $this->productService->getBaseQuery();
        $config = $this->productService->getDataTableConfig();

        $products = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('products/Index'), [
            'products' => $products,
            'filters' => $this->getFilters(['status', 'category_id', 'quality_id', 'has_variants', 'is_new', 'out_of_stock', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.products_columns'),
            'categories' => ProductCategory::active()->get(['id', 'name_en', 'name_ar']),
            'qualities' => ProductQuality::active()->get(['id', 'name_en', 'name_ar']),
        ]);
    }

    public function create()
    {
        $categories = ProductCategory::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $qualities = ProductQuality::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);

        return Inertia::render(SuperAdminPath::view('products/actions/Create'), [
            'categories' => $categories,
            'qualities' => $qualities,
        ]);
    }

    public function createComplex()
    {
        $categories = ProductCategory::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $qualities = ProductQuality::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $colors = \App\Models\ProductVariantColor::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar', 'code']);
        $sizes = \App\Models\ProductVariantSize::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);

        return Inertia::render(SuperAdminPath::view('products/actions/CreateComplex'), [
            'categories' => $categories,
            'qualities' => $qualities,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    public function editComplex(Product $product)
    {
        $categories = ProductCategory::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $qualities = ProductQuality::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $colors = \App\Models\ProductVariantColor::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar', 'code']);
        $sizes = \App\Models\ProductVariantSize::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);

        // Load product with variants and their media
        $product->load(['variants' => function ($query) {
            $query->orderBy('id');
        }, 'variants.color', 'variants.size']);

        // Get existing files for each variant using BaseController method
        $existingVariants = $product->variants->map(function ($variant) {
            $existingMedia = $this->getExistingFilesForEdit($variant, 'variant-image');

            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'color_id' => $variant->color_id,
                'size_id' => $variant->size_id,
                'price' => $variant->price,
                'stock_quantity' => $variant->stock_quantity,
                'out_of_stock' => $variant->out_of_stock,
                'status' => $variant->status,
                'existing_media' => $existingMedia,
            ];
        });

        // Get existing featured image (for size-only variants)
        $existingFiles = $this->getExistingFilesForEdit($product, 'featured');

        // Get existing placement image
        $existingPlacementFiles = $this->getExistingFilesForEdit($product, 'placement');

        return Inertia::render(SuperAdminPath::view('products/actions/EditComplex'), [
            'product' => $product,
            'categories' => $categories,
            'qualities' => $qualities,
            'colors' => $colors,
            'sizes' => $sizes,
            'existingVariants' => $existingVariants,
            'existingFiles' => $existingFiles,
            'existingPlacementFiles' => $existingPlacementFiles,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create the product
            $product = $this->productService->create($request->validated());

            // Handle featured image if provided
            if ($request->has('temp_files') && is_array($request->temp_files) && ! empty($request->temp_files)) {
                $this->fileUploadService->moveToMediaLibrary(
                    $product,
                    $request->temp_files,
                    'featured'
                );
            }

            // Handle placement image if provided (optional)
            if ($request->has('placement_image') && is_array($request->placement_image) && ! empty($request->placement_image)) {
                $this->fileUploadService->moveToMediaLibrary(
                    $product,
                    $request->placement_image,
                    'placement'
                );
            }

            DB::commit();

            return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up temporary files on error
            if ($request->has('temp_files')) {
                $this->fileUploadService->cleanupTempFiles($request->temp_files);
            }
            if ($request->has('placement_image')) {
                $this->fileUploadService->cleanupTempFiles($request->placement_image);
            }

            return back()->withErrors([
                'temp_files' => 'Failed to create product: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function storeComplex(StoreComplexProductRequest $request)
    {
        DB::beginTransaction();

        try {
            // Prepare product data
            $productData = $request->only([
                'name_en',
                'name_ar',
                'slug',
                'description_en',
                'description_ar',
                'category_id',
                'quality_id',
                'sku',
                'status',
            ]);

            // Create product with variants
            $product = $this->productService->createWithVariants($productData, $request->variants);

            // Reload product with variants
            $product->load('variants');

            // Handle variant images
            if ($request->has('variants') && is_array($request->variants)) {
                $createdVariants = $product->variants->all(); // Get all variants as array

                \Log::info('Processing variant images', [
                    'total_variants' => count($createdVariants),
                    'request_variants' => count($request->variants),
                ]);

                foreach ($request->variants as $index => $variantData) {
                    if (isset($variantData['temp_files']) && is_array($variantData['temp_files']) && ! empty($variantData['temp_files'])) {
                        // Get the variant at this index
                        if (isset($createdVariants[$index])) {
                            $variant = $createdVariants[$index];

                            \Log::info('Attaching image to variant', [
                                'variant_id' => $variant->id,
                                'index' => $index,
                                'temp_files_count' => count($variantData['temp_files']),
                            ]);

                            $filesAdded = $this->fileUploadService->moveToMediaLibrary(
                                $variant,
                                $variantData['temp_files'],
                                'variant-image'
                            );

                            \Log::info('Files added to variant', [
                                'variant_id' => $variant->id,
                                'files_added' => $filesAdded,
                            ]);
                        }
                    }
                }
            }

            // Handle featured image if provided (for size-only variants)
            if ($request->has('temp_files') && is_array($request->temp_files) && ! empty($request->temp_files)) {
                $this->fileUploadService->moveToMediaLibrary(
                    $product,
                    $request->temp_files,
                    'featured'
                );
            }

            // Handle placement image if provided
            if ($request->has('placement_image') && is_array($request->placement_image) && ! empty($request->placement_image)) {
                $this->fileUploadService->moveToMediaLibrary(
                    $product,
                    $request->placement_image,
                    'placement'
                );
            }

            DB::commit();

            return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up temporary files on error
            if ($request->has('variants')) {
                foreach ($request->variants as $variantData) {
                    if (isset($variantData['temp_files'])) {
                        $this->fileUploadService->cleanupTempFiles($variantData['temp_files']);
                    }
                }
            }
            if ($request->has('temp_files')) {
                $this->fileUploadService->cleanupTempFiles($request->temp_files);
            }
            if ($request->has('placement_image')) {
                $this->fileUploadService->cleanupTempFiles($request->placement_image);
            }

            return back()->withErrors([
                'variants' => 'Failed to create product: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function updateComplex(UpdateComplexProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        try {
            // Update product data
            $productData = $request->only([
                'name_en',
                'name_ar',
                'slug',
                'description_en',
                'description_ar',
                'category_id',
                'quality_id',
                'sku',
                'status',
            ]);

            $product->update($productData);

            // Track existing variant IDs
            $existingVariantIds = [];

            // Process variants
            foreach ($request->variants as $variantData) {
                if (isset($variantData['id']) && $variantData['id']) {
                    // Update existing variant
                    $variant = $product->variants()->find($variantData['id']);
                    if ($variant) {
                        $variant->update([
                            'color_id' => $variantData['color_id'] ?? null,
                            'size_id' => $variantData['size_id'] ?? null,
                            'price' => $variantData['price'],
                            'stock_quantity' => $variantData['stock_quantity'],
                            'out_of_stock' => $variantData['out_of_stock'] ?? false,
                            'status' => $variantData['status'] ?? true,
                        ]);

                        $existingVariantIds[] = $variant->id;

                        // Handle variant images if new files are uploaded
                        if (isset($variantData['temp_files']) && is_array($variantData['temp_files']) && ! empty($variantData['temp_files'])) {
                            // Filter only new temp files (those with temp_path)
                            $newTempFiles = array_filter($variantData['temp_files'], function ($file) {
                                return isset($file['temp_path']) && ! empty($file['temp_path']);
                            });

                            if (! empty($newTempFiles)) {
                                $this->fileUploadService->moveToMediaLibrary(
                                    $variant,
                                    $newTempFiles,
                                    'variant-image'
                                );
                            }
                        }
                    }
                } else {
                    // Create new variant
                    $newVariant = $product->variants()->create([
                        'color_id' => $variantData['color_id'] ?? null,
                        'size_id' => $variantData['size_id'] ?? null,
                        'price' => $variantData['price'],
                        'stock_quantity' => $variantData['stock_quantity'],
                        'out_of_stock' => $variantData['out_of_stock'] ?? false,
                        'status' => $variantData['status'] ?? true,
                    ]);

                    $existingVariantIds[] = $newVariant->id;

                    // Handle variant images for new variant
                    if (isset($variantData['temp_files']) && is_array($variantData['temp_files']) && ! empty($variantData['temp_files'])) {
                        $this->fileUploadService->moveToMediaLibrary(
                            $newVariant,
                            $variantData['temp_files'],
                            'variant-image'
                        );
                    }
                }
            }

            // Delete variants that were removed
            $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

            // Handle featured image updates if provided (for size-only variants)
            if ($request->has('temp_files') && is_array($request->temp_files)) {
                $this->updateMediaFiles(
                    $product,
                    $request->temp_files,
                    'featured'
                );
            }

            // Handle placement image updates if provided
            if ($request->has('placement_image') && is_array($request->placement_image)) {
                $this->updateMediaFiles(
                    $product,
                    $request->placement_image,
                    'placement'
                );
            }

            DB::commit();

            return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up temporary files on error
            if ($request->has('variants')) {
                foreach ($request->variants as $variantData) {
                    if (isset($variantData['temp_files'])) {
                        $this->fileUploadService->cleanupTempFiles($variantData['temp_files']);
                    }
                }
            }
            if ($request->has('temp_files')) {
                $this->fileUploadService->cleanupTempFiles($request->temp_files);
            }
            if ($request->has('placement_image')) {
                $this->fileUploadService->cleanupTempFiles($request->placement_image);
            }

            return back()->withErrors([
                'variants' => 'Failed to update product: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $qualities = ProductQuality::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);

        // Get existing files in the format expected by the file upload component
        $existingFiles = $this->getExistingFilesForEdit($product, 'featured');
        $existingPlacementFiles = $this->getExistingFilesForEdit($product, 'placement');

        return Inertia::render(SuperAdminPath::view('products/actions/Edit'), [
            'product' => $product->load(['category', 'quality']),
            'categories' => $categories,
            'qualities' => $qualities,
            'existingFiles' => $existingFiles,
            'existingPlacementFiles' => $existingPlacementFiles,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        try {
            // Update the product
            $this->productService->update($product, $request->validated());

            // Handle featured image updates if provided
            if ($request->has('temp_files') && is_array($request->temp_files)) {
                $this->updateMediaFiles(
                    $product,
                    $request->temp_files,
                    'featured'
                );
            }

            // Handle placement image updates if provided (optional)
            if ($request->has('placement_image') && is_array($request->placement_image)) {
                $this->updateMediaFiles(
                    $product,
                    $request->placement_image,
                    'placement'
                );
            }

            DB::commit();

            return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up only new temporary files on error
            if ($request->has('temp_files')) {
                $newTempFiles = $this->getNewTempFiles($request->temp_files);
                if (! empty($newTempFiles)) {
                    $this->fileUploadService->cleanupTempFiles($newTempFiles);
                }
            }
            if ($request->has('placement_image')) {
                $newTempFiles = $this->getNewTempFiles($request->placement_image);
                if (! empty($newTempFiles)) {
                    $this->fileUploadService->cleanupTempFiles($newTempFiles);
                }
            }

            return back()->withErrors([
                'temp_files' => 'Failed to update product: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.products.index');
    }

    public function toggleStatus(Product $product)
    {
        try {
            $this->productService->toggleStatus($product);

            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_status'), __('toast.error'), 'super-admin.products.index');
        }
    }

    public function toggleIsNew(Product $product)
    {
        try {
            $this->productService->toggleIsNew($product);

            return $this->successWithToast(__('toast.is_new_updated_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_is_new'), __('toast.error'), 'super-admin.products.index');
        }
    }

    public function toggleOutOfStock(Product $product)
    {
        try {
            $this->productService->toggleOutOfStock($product);

            return $this->successWithToast(__('toast.out_of_stock_updated_successfully'), __('toast.success'), 'super-admin.products.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_out_of_stock'), __('toast.error'), 'super-admin.products.index');
        }
    }
}
