<?php

namespace App\Http\Controllers\SuperAdmin;

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

        return $this->successWithToast('Product color created successfully', 'Success', 'super-admin.product-colors.index');
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

        return $this->successWithToast('Product color updated successfully', 'Success', 'super-admin.product-colors.index');
    }

    public function destroy(ProductVariantColor $productColor)
    {
        $this->colorService->delete($productColor);

        return $this->successWithToast('Product color deleted successfully', 'Success', 'super-admin.product-colors.index');
    }

    public function toggleStatus(ProductVariantColor $productColor)
    {
        try {
            $this->colorService->toggleStatus($productColor);

            $status = $productColor->status ? 'activated' : 'deactivated';
            $message = "Product color '{$productColor->name_en}' has been {$status} successfully.";

            return $this->successWithToast($message, 'Color ' . ucfirst($status));
        } catch (\Exception $e) {
            return $this->errorWithToast('Failed to update color status. Please try again.');
        }
    }
}
