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
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private ProductServicePortal $productService,
        private CartServicePortal $cartService
    ) {}

    public function home(): View
    {
        $locale = app()->getLocale();
        $defaults = config('seo.defaults', []);

        // Set SEO for homepage
        seo_data([
            'title' => $defaults['title'][$locale] ?? $defaults['title']['en'] ?? 'Abo Lira',
            'description' => $defaults['description'][$locale] ?? $defaults['description']['en'] ?? '',
            'keywords' => $defaults['keywords'][$locale] ?? $defaults['keywords']['en'] ?? '',
            'image' => $defaults['image'] ?? asset('logos/logo.png'),
            'type' => 'website',
        ]);

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
        $locale = app()->getLocale();

        $title = $locale === 'ar'
            ? 'من نحن | أبو ليرة - قطع غيار الدراجات النارية'
            : 'About Us | Abo Lira - Motorcycle Parts';

        $description = $locale === 'ar'
            ? 'تعرف على أبو ليرة - متجرك الموثوق لقطع غيار الدراجات النارية الأصلية وخدمات الصيانة الاحترافية. خبرة تمتد لسنوات في عالم الدراجات النارية.'
            : 'Learn about Abo Lira - Your trusted source for genuine motorcycle parts and professional maintenance services. Years of expertise in the motorcycle industry.';

        seo_data([
            'title' => $title,
            'description' => $description,
            'type' => 'website',
        ]);

        seo_breadcrumb($locale === 'ar' ? 'من نحن' : 'About Us', route('about'));

        $cartItemsCount = $this->cartService->getCartCount();

        return view('about', compact('cartItemsCount'));
    }

    public function needs(): View
    {
        $locale = app()->getLocale();

        $title = $locale === 'ar'
            ? 'طلب منتج | أبو ليرة - قطع غيار الدراجات النارية'
            : 'Request Product | Abo Lira - Motorcycle Parts';

        $description = $locale === 'ar'
            ? 'اطلب قطع غيار دراجات نارية غير متوفرة في المتجر. نحن نبحث عن أفضل المنتجات الأصلية لك.'
            : 'Request motorcycle parts not available in the store. We search for the best genuine products for you.';

        seo_data([
            'title' => $title,
            'description' => $description,
            'type' => 'website',
        ]);

        seo_breadcrumb($locale === 'ar' ? 'طلب منتج' : 'Request Product', route('needs'));

        $cartItemsCount = $this->cartService->getCartCount();

        return view('needs', compact('cartItemsCount'));
    }

    public function requestProduct(NeedRequest $request): RedirectResponse
    {
        $message = $request->input('message') ? $request->input('message') : null;

        $need = Need::create([
            'f_name' => $request->input('f_name'),
            'l_name' => $request->input('l_name'),
            'phone_number' => $request->input('phone_number'),
            'message' => $message,
        ]);

        if ($request->hasFile('image')) {
            $need->addMediaFromRequest('image')->toMediaCollection('request-image');
        }

        return redirect()->route('needs')->with('success', __('needs.request_submitted_successfully'));
    }

    public function shop(ShopRequest $request): View
    {
        $locale = app()->getLocale();
        $result = $this->productService->getShopProducts($request);
        $categories = $result['categories'];
        $products = $result['products'];
        $activeCategory = $result['activeCategory'];

        // Build SEO title and description based on active category
        $categoryName = $activeCategory
            ? ($locale === 'ar' ? $activeCategory->name_ar : $activeCategory->name_en)
            : ($locale === 'ar' ? 'جميع المنتجات' : 'All Products');

        $title = $locale === 'ar'
            ? "{$categoryName} | متجر أبو ليرة - قطع غيار الدراجات النارية"
            : "{$categoryName} | Abo Lira Shop - Motorcycle Parts";

        $description = $locale === 'ar'
            ? "تصفح {$categoryName} من قطع غيار الدراجات النارية الأصلية. أسعار منافسة وضمان الجودة."
            : "Browse {$categoryName} of genuine motorcycle parts. Competitive prices and quality guarantee.";

        seo_data([
            'title' => $title,
            'description' => $description,
            'type' => 'website',
        ]);

        seo_breadcrumb($locale === 'ar' ? 'المتجر' : 'Shop', route('shop'));

        $cartItemsCount = $this->cartService->getCartCount();

        return view('shop', compact('categories', 'products', 'activeCategory', 'cartItemsCount'));
    }

    public function detail(string $slug): View|RedirectResponse
    {
        $product = $this->productService->getProductDetails($slug);

        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $locale = app()->getLocale();
        $productName = $product->name;
        $productDescription = $product->description ? Str::limit($product->description, 160) : '';
        $productImage = $product->image ?: asset('logos/logo.png');

        // Get product price from first variant (discount already applied by ProductServicePortal)
        $firstVariant = $product->variants->first();
        $price = $firstVariant?->price ?? 0;

        $currency = config('seo.product.default_currency', 'USD');
        $availability = $product->status ? 'InStock' : 'OutOfStock';
        $brand = $product->category?->name ?? null;

        // Build SEO title
        $title = $locale === 'ar'
            ? "{$productName} | أبو ليرة - قطع غيار الدراجات النارية"
            : "{$productName} | Abo Lira - Motorcycle Parts";

        // Set product SEO
        seo_product(
            title: $title,
            description: $productDescription ?: ($locale === 'ar'
                ? "اشتري {$productName} من أبو ليرة. قطع غيار أصلية بأسعار منافسة."
                : "Buy {$productName} from Abo Lira. Genuine parts at competitive prices."),
            image: $productImage,
            price: (float) $price,
            currency: $currency,
            availability: $availability,
            brand: $brand
        );

        // Add breadcrumbs
        seo_breadcrumb($locale === 'ar' ? 'المتجر' : 'Shop', route('shop'));
        if ($product->category) {
            $categoryName = $locale === 'ar' ? $product->category->name_ar : $product->category->name_en;
            seo_breadcrumb($categoryName, route('shop', ['category' => $product->category->slug]));
        }
        seo_breadcrumb($productName, route('detail', $product->slug));

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
