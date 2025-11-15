<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Models\Product;
use App\Navigation\SuperAdminPath;
use App\Services\Core\DiscountService;
use Inertia\Inertia;

class DiscountController extends BaseController
{
    public function __construct(
        private DiscountService $discountService
    ) {}

    public function index()
    {
        $query = $this->discountService->getBaseQuery();
        $config = $this->discountService->getDataTableConfig();

        $discounts = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        // Add name accessor to each product
        $discounts->getCollection()->transform(function ($product) {
            $product->name = app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en;
            return $product;
        });

        return Inertia::render(SuperAdminPath::view('discounts/Index'), [
            'discounts' => $discounts,
            'filters' => $this->getFilters(['has_limited_time_discount', 'discount_start_from', 'discount_start_to', 'discount_end_from', 'discount_end_to']),
            'columnLabels' => __('datatable.discounts_columns'),
        ]);
    }

    public function create()
    {
        $products = $this->discountService->getProductsWithoutDiscounts()->get();

        return Inertia::render(SuperAdminPath::view('discounts/Create'), [
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en,
                    'sku' => $product->sku,
                ];
            }),
        ]);
    }

    public function store(StoreDiscountRequest $request)
    {
        $product = $this->discountService->findByIdOrFail($request->product_id);

        $this->discountService->createDiscount($product, $request->validated());

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.discounts.index');
    }

    public function show(Product $product)
    {
        $product = $this->discountService->findByIdOrFail($product->id);

        // Add image and prepare variants
        $product->image = $product->getFirstMediaUrl('featured');

        // Load variants with images
        $product->load(['variants' => function ($query) {
            $query->with(['color', 'size']);
        }]);

        $product->variants->transform(function ($variant) {
            $variant->image = $variant->getFirstMediaUrl('variant-image');
            return $variant;
        });

        return Inertia::render(SuperAdminPath::view('discounts/Show'), [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        $product = $this->discountService->findByIdOrFail($product->id);

        return Inertia::render(SuperAdminPath::view('discounts/Edit'), [
            'product' => $product,
        ]);
    }

    public function update(UpdateDiscountRequest $request, Product $product)
    {
        $product = $this->discountService->findByIdOrFail($product->id);

        $this->discountService->updateDiscount($product, $request->validated());

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.discounts.index');
    }

    public function destroy(Product $product)
    {
        $this->discountService->deleteDiscount($product);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.discounts.index');
    }
}
