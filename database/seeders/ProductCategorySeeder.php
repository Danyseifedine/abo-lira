<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Main Categories
            ['name_en' => 'Engine Parts', 'name_ar' => 'قطع المحرك', 'slug' => 'engine-parts', 'status' => true],
            ['name_en' => 'Wheels & Tires', 'name_ar' => 'العجلات والإطارات', 'slug' => 'wheels-tires', 'status' => true],
            ['name_en' => 'Electrical Parts', 'name_ar' => 'القطع الكهربائية', 'slug' => 'electrical-parts', 'status' => true],
            ['name_en' => 'Lighting', 'name_ar' => 'الإضاءة', 'slug' => 'lighting', 'status' => true],
            ['name_en' => 'Body & Frame', 'name_ar' => 'الهيكل والإطار', 'slug' => 'body-frame', 'status' => true],
            ['name_en' => 'Filters & Fluids', 'name_ar' => 'الفلاتر والسوائل', 'slug' => 'filters-fluids', 'status' => true],
            ['name_en' => 'Accessories', 'name_ar' => 'الإكسسوارات', 'slug' => 'accessories', 'status' => true],
            ['name_en' => 'Safety Gear', 'name_ar' => 'معدات السلامة', 'slug' => 'safety-gear', 'status' => true],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
