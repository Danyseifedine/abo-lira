<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\NeedRequest;
use App\Http\Requests\Portal\ShopRequest;
use App\Models\Need;
use App\Services\Portal\CartServicePortal;
use App\Services\Portal\ProductServicePortal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private ProductServicePortal $productService,
        private CartServicePortal $cartService
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
            $accessoriesProducts = $this->productService->getOldestProductsByCategoryCached($accessoriesCategory->id, 6);
        }

        $productsLessThanPrice5 = $this->productService->getOldestProductsByCategoryCached(5, 6);

        $cartItemsCount = $this->cartService->getCartCount();

        return view('landing', compact('categories', 'accessoriesProducts', 'productsLessThanPrice5', 'cartItemsCount'));
    }

    public function about(): View
    {
        $cartItemsCount = $this->cartService->getCartCount();

        return view('about', compact('cartItemsCount'));
    }

    public function needs(): View
    {
        $cartItemsCount = $this->cartService->getCartCount();

        return view('needs', compact('cartItemsCount'));
    }

    public function requestProduct(NeedRequest $request): RedirectResponse
    {
        $need = Need::create([
            'f_name' => $request->input('f_name'),
            'l_name' => $request->input('l_name'),
            'phone_number' => $request->input('phone_number'),
            'message' => $request->input('message'),
        ]);

        if ($request->hasFile('image')) {
            $need->addMediaFromRequest('image')->toMediaCollection('request-image');
        }

        return redirect()->route('needs')->with('success', 'Need created successfully');
    }

    public function shop(ShopRequest $request): View
    {
        $result = $this->productService->getShopProducts($request);
        $categories = $result['categories'];
        $products = $result['products'];
        $activeCategory = $result['activeCategory'];

        $cartItemsCount = $this->cartService->getCartCount();

        return view('shop', compact('categories', 'products', 'activeCategory', 'cartItemsCount'));
    }

    public function detail(string $slug): View|RedirectResponse
    {
        $product = $this->productService->getProductDetails($slug);

        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cartItemsCount = $this->cartService->getCartCount();

        return view('detail', compact('product', 'cartItemsCount'));
    }

    public function searchProducts(string $search): JsonResponse
    {
        $products = $this->productService->getSearchProducts($search);

        $html = view('components.search-results', compact('products'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Product found',
            'html' => $html,
        ]);
    }
}
