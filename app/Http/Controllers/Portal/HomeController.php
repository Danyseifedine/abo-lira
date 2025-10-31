<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Portal\ProductServicePortal;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        private ProductServicePortal $productService
    ) {}


    public function home(): View
    {
        // Cache categories for 1 hour with eager loaded media
        $categories = cache()->remember('portal_active_categories', 3600, function () {
            return ProductCategory::with('media')->active()->get();
        });

        $accessoriesCategory = $categories->firstWhere('slug', 'accessories');

        // Cache product queries for 5 minutes (short cache to keep products relatively fresh)
        $cacheKey = 'portal_home_accessories_' . $accessoriesCategory->id;
        $accessoriesProducts = cache()->remember($cacheKey, 300, function () use ($accessoriesCategory) {
            return $this->productService->getRandomProductsByCategory(true, $accessoriesCategory->id, 8);
        });

        $productsLessThanPrice5 = cache()->remember('portal_home_products_under_5', 300, function () {
            return $this->productService->getProductLessThanPrice(true, 5, 8);
        });

        return view('landing', compact('categories', 'accessoriesProducts', 'productsLessThanPrice5'));
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function shop(): View
    {
        return view('shop');
    }

    public function cart(): View
    {
        return view('cart');
    }

    public function detail(): View
    {
        return view('detail');
    }

    public function checkout(): View
    {
        return view('checkout');
    }
}
