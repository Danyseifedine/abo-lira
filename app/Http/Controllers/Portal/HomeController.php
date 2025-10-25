<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
    {

        // category counts
        $categories = ProductCategory::active()->get();

        return view('landing', compact('categories'));
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
