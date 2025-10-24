<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductSize\StoreProductSizeRequest;
use App\Http\Requests\ProductSize\UpdateProductSizeRequest;
use App\Models\ProductVariantSize;
use App\Navigation\SuperAdminPath;
use App\Services\Core\ProductSizeService;
use Inertia\Inertia;

class ProductSizesController extends BaseController
{
    public function __construct(
        private ProductSizeService $sizeService
    ) {}

    public function index()
    {
        $query = $this->sizeService->getBaseQuery();
        $config = $this->sizeService->getDataTableConfig();

        $sizes = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('product-sizes/Index'), [
            'sizes' => $sizes,
            'filters' => $this->getFilters(['status', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.product_sizes_columns'),
        ]);
    }

    public function create()
    {
        return Inertia::render(SuperAdminPath::view('product-sizes/actions/Create'));
    }

    public function store(StoreProductSizeRequest $request)
    {
        $this->sizeService->create($request->validated());

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.product-sizes.index');
    }

    public function edit(ProductVariantSize $productSize)
    {
        return Inertia::render(SuperAdminPath::view('product-sizes/actions/Edit'), [
            'size' => $productSize,
        ]);
    }

    public function update(UpdateProductSizeRequest $request, ProductVariantSize $productSize)
    {
        $this->sizeService->update($productSize, $request->validated());

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.product-sizes.index');
    }

    public function destroy(ProductVariantSize $productSize)
    {
        $this->sizeService->delete($productSize);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.product-sizes.index');
    }

    public function toggleStatus(ProductVariantSize $productSize)
    {
        try {
            $this->sizeService->toggleStatus($productSize);


            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.product-sizes.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_status'), __('toast.error'), 'super-admin.product-sizes.index');
        }
    }
}
