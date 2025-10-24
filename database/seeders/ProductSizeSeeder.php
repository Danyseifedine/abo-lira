<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductSize;
use App\Models\ProductVariantSize;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            // Standard Sizes
            ['name_en' => 'XXS', 'name_ar' => 'XXS', 'status' => true],
            ['name_en' => 'XS', 'name_ar' => 'XS', 'status' => true],
            ['name_en' => 'S', 'name_ar' => 'S', 'status' => true],
            ['name_en' => 'M', 'name_ar' => 'M', 'status' => true],
            ['name_en' => 'L', 'name_ar' => 'L', 'status' => true],
            ['name_en' => 'XL', 'name_ar' => 'XL', 'status' => true],
            ['name_en' => '2XL', 'name_ar' => '2XL', 'status' => true],
            ['name_en' => '3XL', 'name_ar' => '3XL', 'status' => true],
            ['name_en' => '4XL', 'name_ar' => '4XL', 'status' => true],
            ['name_en' => '5XL', 'name_ar' => '5XL', 'status' => true],

            // Numeric Sizes
            ['name_en' => '28', 'name_ar' => '28', 'status' => true],
            ['name_en' => '30', 'name_ar' => '30', 'status' => true],
            ['name_en' => '32', 'name_ar' => '32', 'status' => true],
            ['name_en' => '34', 'name_ar' => '34', 'status' => true],
            ['name_en' => '36', 'name_ar' => '36', 'status' => true],
            ['name_en' => '38', 'name_ar' => '38', 'status' => true],
            ['name_en' => '40', 'name_ar' => '40', 'status' => true],
            ['name_en' => '42', 'name_ar' => '42', 'status' => true],
            ['name_en' => '44', 'name_ar' => '44', 'status' => true],
            ['name_en' => '46', 'name_ar' => '46', 'status' => true],
            ['name_en' => '48', 'name_ar' => '48', 'status' => true],
            ['name_en' => '50', 'name_ar' => '50', 'status' => true],

            // Universal
            ['name_en' => 'One Size', 'name_ar' => 'مقاس واحد', 'status' => true],

            // Custom Sizes
            ['name_en' => 'Small Size', 'name_ar' => 'مقاس صغير', 'status' => true],
            ['name_en' => 'Medium Size', 'name_ar' => 'مقاس متوسط', 'status' => true],
            ['name_en' => 'Large Size', 'name_ar' => 'مقاس كبير', 'status' => true],

        ];

        foreach ($sizes as $size) {
            ProductVariantSize::create($size);
        }
    }
}
