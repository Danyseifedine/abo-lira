<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
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
