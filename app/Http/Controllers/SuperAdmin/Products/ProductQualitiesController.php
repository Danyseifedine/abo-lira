<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductQuality\StoreProductQualityRequest;
use App\Http\Requests\ProductQuality\UpdateProductQualityRequest;
use App\Models\ProductQuality;
use App\Navigation\SuperAdminPath;
use App\Services\Core\ProductQualityService;
use Inertia\Inertia;

class ProductQualitiesController extends BaseController
{
    public function __construct(
        private ProductQualityService $qualityService
    ) {}

    public function index()
    {
        $query = $this->qualityService->getBaseQuery();
        $config = $this->qualityService->getDataTableConfig();

        $qualities = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('product-qualities/Index'), [
            'qualities' => $qualities,
            'filters' => $this->getFilters(['status', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.product_qualities_columns'),
        ]);
    }

    public function create()
    {
        return Inertia::render(SuperAdminPath::view('product-qualities/actions/Create'));
    }

    public function store(StoreProductQualityRequest $request)
    {
        $this->qualityService->create($request->validated());

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.product-qualities.index');
    }

    public function edit(ProductQuality $productQuality)
    {
        return Inertia::render(SuperAdminPath::view('product-qualities/actions/Edit'), [
            'quality' => $productQuality,
        ]);
    }

    public function update(UpdateProductQualityRequest $request, ProductQuality $productQuality)
    {
        $this->qualityService->update($productQuality, $request->validated());

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.product-qualities.index');
    }

    public function destroy(ProductQuality $productQuality)
    {
        $this->qualityService->delete($productQuality);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.product-qualities.index');
    }

    public function toggleStatus(ProductQuality $productQuality)
    {
        try {
            $this->qualityService->toggleStatus($productQuality);

            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.product-qualities.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_status'), __('toast.error'), 'super-admin.product-qualities.index');
        }
    }
}
