<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Need;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductQuality;
use App\Models\ProductVariant;
use App\Models\ProductVariantColor;
use App\Models\ProductVariantSize;
use App\Models\User;
use App\Navigation\SuperAdminPath;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:access-super-admin-dashboard')->only('index');
    }

    public function index()
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        // Get all statistics
        $stats = [
            // Orders
            'orders_count' => Order::count(),
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'orders_this_month' => Order::where('created_at', '>=', $thisMonth)->count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'orders_accepted' => Order::where('status', 'accepted')->count(),
            'orders_on_the_way' => Order::where('status', 'on_the_way')->count(),
            'orders_completed' => Order::where('status', 'completed')->count(),
            'orders_rejected' => Order::where('status', 'rejected')->count(),
            'orders_refunded' => Order::where('status', 'refunded')->count(),

            // Sales
            'total_sales' => Order::sum('total_amount') ?? 0,
            'sales_today' => Order::whereDate('created_at', $today)->sum('total_amount') ?? 0,
            'sales_this_month' => Order::where('created_at', '>=', $thisMonth)->sum('total_amount') ?? 0,
            'average_order_value' => Order::count() > 0 ? Order::avg('total_amount') : 0,

            // Products
            'products_count' => Product::count(),
            'products_active' => Product::where('status', true)->count(),
            'products_inactive' => Product::where('status', false)->count(),
            'products_with_variants' => Product::where('has_variants', true)->count(),
            'products_with_discounts' => Product::whereNotNull('discount_price')->count(),
            'products_active_discounts' => Product::where('is_discounted', true)->count(),
            'products_scheduled_discounts' => Product::where('is_discounted', false)
                ->whereNotNull('discount_price')
                ->whereNotNull('discount_start_date')
                ->whereDate('discount_start_date', '>', $today)
                ->count(),

            // Categories
            'categories_count' => ProductCategory::count(),
            'categories_active' => ProductCategory::where('status', true)->count(),

            // Sizes
            'sizes_count' => ProductVariantSize::count(),
            'sizes_active' => ProductVariantSize::where('status', true)->count(),

            // Qualities
            'qualities_count' => ProductQuality::count(),
            'qualities_active' => ProductQuality::where('status', true)->count(),

            // Colors
            'colors_count' => ProductVariantColor::count(),
            'colors_active' => ProductVariantColor::where('status', true)->count(),

            // Variants
            'variants_count' => ProductVariant::count(),
            'variants_active' => ProductVariant::where('status', true)->count(),
            'variants_inactive' => ProductVariant::where('status', false)->count(),

            // Needs
            'needs_unread_count' => Need::where('status', 'unread')->count(),
            'needs_read_count' => Need::where('status', 'read')->count(),

            // Users
            'users_count' => User::count(),
            'users_active' => User::where('is_active', true)->count(),

            // Most Bought Product
            'most_bought_product' => Product::orderBy('bought_count', 'desc')
                ->first(['id', 'name_en', 'name_ar', 'bought_count', 'sku']),
        ];

        return Inertia::render(SuperAdminPath::view("Index"), [
            'stats' => $stats,
        ]);
    }
}
