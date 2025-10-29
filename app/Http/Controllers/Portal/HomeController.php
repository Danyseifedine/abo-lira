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
        $categories = ProductCategory::active()->get();
        $accessoriesCategory = $categories->firstWhere('slug', 'accessories');

        $accessoriesProducts = $this->productService->getRandomProductsByCategory(true, $accessoriesCategory->id, 8);
        $productsLessThanPrice5 = $this->productService->getProductLessThanPrice(true, 5, 8);
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
