<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProductQuality;
use Illuminate\Database\Seeder;

class ProductQualitySeeder extends Seeder
{
    public function run(): void
    {
        $qualities = [
            ['name_en' => 'Original', 'name_ar' => 'أصلي', 'slug' => 'original', 'status' => true],
            ['name_en' => 'Premium', 'name_ar' => 'بريميوم', 'slug' => 'premium', 'status' => true],
            ['name_en' => 'Economy', 'name_ar' => 'اقتصادي', 'slug' => 'economy', 'status' => true],
            ['name_en' => 'High Performance', 'name_ar' => 'عالي الأداء', 'slug' => 'high-performance', 'status' => true],
            ['name_en' => 'OE Replacement', 'name_ar' => 'بديل أصلي', 'slug' => 'oe-replacement', 'status' => true],

            ['name_en' => 'Grade A', 'name_ar' => 'درجة A', 'slug' => 'grade-a', 'status' => true],
            ['name_en' => 'Grade B', 'name_ar' => 'درجة B', 'slug' => 'grade-b', 'status' => true],
            ['name_en' => 'Grade C', 'name_ar' => 'درجة C', 'slug' => 'grade-c', 'status' => true],
            ['name_en' => 'Grade D', 'name_ar' => 'درجة D', 'slug' => 'grade-d', 'status' => true],

            ['name_en' => 'Medium Quality', 'name_ar' => 'جودة متوسطة', 'slug' => 'medium-quality', 'status' => true],
            ['name_en' => 'Good Quality', 'name_ar' => 'جودة جيدة', 'slug' => 'good-quality', 'status' => true],
            ['name_en' => 'Very Good Quality', 'name_ar' => 'جودة جيدة جدًا', 'slug' => 'very-good-quality', 'status' => true],
            ['name_en' => 'Excellent Quality', 'name_ar' => 'جودة ممتازة', 'slug' => 'excellent-quality', 'status' => true],
        ];

        foreach ($qualities as $quality) {
            ProductQuality::create($quality);
        }
    }
}
