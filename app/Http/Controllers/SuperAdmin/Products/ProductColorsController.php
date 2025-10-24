<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductColor\StoreProductColorRequest;
use App\Http\Requests\ProductColor\UpdateProductColorRequest;
use App\Models\ProductVariantColor;
use App\Navigation\SuperAdminPath;
use App\Services\Core\ProductColorService;
use Inertia\Inertia;

class ProductColorsController extends BaseController
{
    public function __construct(
        private ProductColorService $colorService
    ) {}

    public function index()
    {
        $query = $this->colorService->getBaseQuery();
        $config = $this->colorService->getDataTableConfig();

        $colors = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('product-colors/Index'), [
            'colors' => $colors,
            'filters' => $this->getFilters(['status', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.product_colors_columns'),
        ]);
    }

    public function create()
    {
        return Inertia::render(SuperAdminPath::view('product-colors/actions/Create'));
    }

    public function store(StoreProductColorRequest $request)
    {
        $this->colorService->create($request->validated());

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.product-colors.index');
    }

    public function edit(ProductVariantColor $productColor)
    {
        return Inertia::render(SuperAdminPath::view('product-colors/actions/Edit'), [
            'color' => $productColor,
        ]);
    }

    public function update(UpdateProductColorRequest $request, ProductVariantColor $productColor)
    {
        $this->colorService->update($productColor, $request->validated());

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.product-colors.index');
    }

    public function destroy(ProductVariantColor $productColor)
    {
        $this->colorService->delete($productColor);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.product-colors.index');
    }

    public function toggleStatus(ProductVariantColor $productColor)
    {
        try {
            $this->colorService->toggleStatus($productColor);

            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.product-colors.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_color_status'), __('toast.error'), 'super-admin.product-colors.index');
        }
    }
}
