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
            ['name_en' => 'Filters & Oil', 'name_ar' => 'الفلاتر والزيوت', 'slug' => 'filters-oil', 'status' => true],
            ['name_en' => 'Safety Gear', 'name_ar' => 'معدات السلامة', 'slug' => 'safety-gear', 'status' => true],
            ['name_en' => 'Storage & Luggage', 'name_ar' => 'التخزين والحقائب', 'slug' => 'storage-luggage', 'status' => true],
            ['name_en' => 'Handlebars & Mirrors', 'name_ar' => 'المقابض والمرايا', 'slug' => 'handlebars-mirrors', 'status' => true],
            ['name_en' => 'Seats & Covers', 'name_ar' => 'المقاعد والأغطية', 'slug' => 'seats-covers', 'status' => true],

        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
