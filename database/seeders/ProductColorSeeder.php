<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductColor;
use App\Models\ProductVariantColor;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            // Basic Colors
            ['name_en' => 'Black', 'name_ar' => 'أسود', 'code' => '#000000', 'status' => true],
            ['name_en' => 'White', 'name_ar' => 'أبيض', 'code' => '#FFFFFF', 'status' => true],
            ['name_en' => 'Gray', 'name_ar' => 'رمادي', 'code' => '#808080', 'status' => true],
            ['name_en' => 'Light Gray', 'name_ar' => 'رمادي فاتح', 'code' => '#D3D3D3', 'status' => true],
            ['name_en' => 'Dark Gray', 'name_ar' => 'رمادي غامق', 'code' => '#404040', 'status' => true],
            ['name_en' => 'Silver', 'name_ar' => 'فضي', 'code' => '#C0C0C0', 'status' => true],
            ['name_en' => 'Charcoal', 'name_ar' => 'فحمي', 'code' => '#36454F', 'status' => true],

            // Red Shades
            ['name_en' => 'Red', 'name_ar' => 'أحمر', 'code' => '#FF0000', 'status' => true],
            ['name_en' => 'Dark Red', 'name_ar' => 'أحمر غامق', 'code' => '#8B0000', 'status' => true],
            ['name_en' => 'Maroon', 'name_ar' => 'عنابي', 'code' => '#800000', 'status' => true],
            ['name_en' => 'Pink', 'name_ar' => 'وردي', 'code' => '#FFC0CB', 'status' => true],

            // Blue Shades
            ['name_en' => 'Blue', 'name_ar' => 'أزرق', 'code' => '#0000FF', 'status' => true],
            ['name_en' => 'Navy Blue', 'name_ar' => 'أزرق كحلي', 'code' => '#000080', 'status' => true],
            ['name_en' => 'Sky Blue', 'name_ar' => 'أزرق سماوي', 'code' => '#87CEEB', 'status' => true],
            ['name_en' => 'Turquoise', 'name_ar' => 'تركواز', 'code' => '#40E0D0', 'status' => true],
            ['name_en' => 'Cyan', 'name_ar' => 'سماوي', 'code' => '#00FFFF', 'status' => true],

            // Green Shades
            ['name_en' => 'Green', 'name_ar' => 'أخضر', 'code' => '#008000', 'status' => true],
            ['name_en' => 'Dark Green', 'name_ar' => 'أخضر غامق', 'code' => '#006400', 'status' => true],
            ['name_en' => 'Lime Green', 'name_ar' => 'أخضر ليموني', 'code' => '#32CD32', 'status' => true],
            ['name_en' => 'Olive', 'name_ar' => 'زيتوني', 'code' => '#808000', 'status' => true],

            // Yellow & Orange Shades
            ['name_en' => 'Yellow', 'name_ar' => 'أصفر', 'code' => '#FFFF00', 'status' => true],
            ['name_en' => 'Gold', 'name_ar' => 'ذهبي', 'code' => '#FFD700', 'status' => true],
            ['name_en' => 'Orange', 'name_ar' => 'برتقالي', 'code' => '#FFA500', 'status' => true],
            ['name_en' => 'Dark Orange', 'name_ar' => 'برتقالي غامق', 'code' => '#FF8C00', 'status' => true],

            // Brown & Beige Shades
            ['name_en' => 'Brown', 'name_ar' => 'بني', 'code' => '#A52A2A', 'status' => true],
            ['name_en' => 'Dark Brown', 'name_ar' => 'بني غامق', 'code' => '#654321', 'status' => true],
            ['name_en' => 'Beige', 'name_ar' => 'بيج', 'code' => '#F5F5DC', 'status' => true],
            ['name_en' => 'Tan', 'name_ar' => 'تان', 'code' => '#D2B48C', 'status' => true],

            // Purple & Violet Shades
            ['name_en' => 'Purple', 'name_ar' => 'بنفسجي', 'code' => '#800080', 'status' => true],
            ['name_en' => 'Violet', 'name_ar' => 'بنفسجي فاتح', 'code' => '#EE82EE', 'status' => true],
            ['name_en' => 'Magenta', 'name_ar' => 'أرجواني', 'code' => '#FF00FF', 'status' => true],

            // Other Colors
            ['name_en' => 'Cream', 'name_ar' => 'كريمي', 'code' => '#FFFDD0', 'status' => true],
            ['name_en' => 'Ivory', 'name_ar' => 'عاجي', 'code' => '#FFFFF0', 'status' => true],

            // Multi-color
            ['name_en' => 'Multicolor', 'name_ar' => 'متعدد الألوان', 'code' => '#FF6347', 'status' => true],
        ];

        foreach ($colors as $color) {
            ProductVariantColor::create($color);
        }
    }
}
