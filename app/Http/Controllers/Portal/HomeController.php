<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Portal\ProductServicePortal;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        private ProductServicePortal $productService
    ) {}


    public function home(): View
    {
        // Don't cache categories - they're fast with indexes and already optimized
        $categories = $this->productService->getProductCategoriesCached();

        // Find the "accessories" category (by slug or name_en; adjust as needed)
        $accessoriesCategory = $categories->first(function ($category) {
            return $category->slug === 'accessories' || $category->name_en === 'Accessories';
        });

        $accessoriesProducts = null;
        if ($accessoriesCategory) {
            $accessoriesProducts = $this->productService->getRandomProductsByCategoryCached($accessoriesCategory->id, 8);
        }

        $productsLessThanPrice5 = $this->productService->getProductLessThanPriceCached(5, 8);

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

    public function detail(string $slug): View|RedirectResponse
    {
        $product = $this->productService->getProductDetails($slug);
        
        if(!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        return view('detail', compact('product'));
    }

    public function checkout(): View
    {
        return view('checkout');
    }
}
