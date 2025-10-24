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
use Inertia\Inertia;

class ProductsController extends BaseController
{
    public function __construct(
        private ProductService $productService
    ) {}

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
            'filters' => $this->getFilters(['status', 'category_id', 'quality_id', 'has_variants', 'is_new', 'created_from', 'created_to']),
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
        $product = $this->productService->create($request->validated());

        // Handle media files if provided
        if ($request->has('temp_files') && is_array($request->temp_files)) {
            $this->productService->syncMedia($product, $request->temp_files);
        }

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.products.index');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);
        $qualities = ProductQuality::active()->orderBy('name_en')->get(['id', 'name_en', 'name_ar']);

        // Get existing media
        $existingMedia = $product->getMedia('products')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'name' => $media->file_name,
                'size' => $media->size,
            ];
        });

        return Inertia::render(SuperAdminPath::view('products/actions/Edit'), [
            'product' => $product->load(['category', 'quality']),
            'categories' => $categories,
            'qualities' => $qualities,
            'existingMedia' => $existingMedia,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        // Handle media files if provided
        if ($request->has('temp_files') && is_array($request->temp_files)) {
            $this->productService->syncMedia($product, $request->temp_files);
        }

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.products.index');
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
}
