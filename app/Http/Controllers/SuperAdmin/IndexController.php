<?php

namespace App\Http\Controllers\SuperAdmin;

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
        return Inertia::render(SuperAdminPath::view("Index"));
    }
}
