<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Default Settings - Abo Lira Motorcycle Parts
    |--------------------------------------------------------------------------
    |
    | Default SEO settings for your motorcycle parts e-commerce platform
    |
    */

    'default_author' => 'Abo Lira Team',

    'title_separator' => '|',

    'twitter_username' => '@abolira',

    'facebook_app_id' => env('FACEBOOK_APP_ID'),

    /*
    |--------------------------------------------------------------------------
    | Organization Information (Schema.org)
    |--------------------------------------------------------------------------
    |
    | Used for generating Organization structured data
    |
    */

    'organization' => [
        'name' => 'Abo Lira Motorcycle Parts',
        'url' => env('APP_URL', 'https://abolira.com'),
        'logo' => env('APP_URL', 'https://abolira.com') . '/assets/images/logo.png',
        'description' => [
            'ar' => 'أبو ليرة - متجرك الموثوق لقطع غيار الدراجات النارية الأصلية وخدمات الصيانة الاحترافية',
            'en' => 'Abo Lira - Your trusted source for genuine motorcycle parts and professional maintenance services'
        ],
        'contact' => [
            '@type' => 'ContactPoint',
            'telephone' => '+961-XX-XXXXXX',
            'contactType' => 'Customer Service',
            'areaServed' => 'LB',
            'availableLanguage' => ['Arabic', 'English']
        ],
        'social_links' => [
            'https://facebook.com/abolira',
            'https://instagram.com/abolira',
            'https://twitter.com/abolira',
            'https://youtube.com/@abolira'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags (Multi-language)
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'title' => [
            'ar' => 'أبو ليرة - قطع غيار الدراجات النارية الأصلية والإصلاح الاحترافي',
            'en' => 'Abo Lira - Premium Motorcycle Parts & Professional Repair Services'
        ],
        'description' => [
            'ar' => 'متجرك الموثوق لقطع غيار الدراجات النارية الأصلية، خدمات الصيانة والإصلاح الاحترافية. نوفر قطع غيار لجميع الماركات مع ضمان الجودة وأسعار منافسة. خبرة تمتد لسنوات في عالم الدراجات النارية.',
            'en' => 'Your trusted destination for authentic motorcycle parts, professional maintenance and repair services. We supply genuine parts for all brands with quality guarantee and competitive prices. Years of expertise in the motorcycle industry.'
        ],
        'keywords' => [
            'ar' => 'قطع غيار دراجات نارية, صيانة دراجات, إصلاح موتور, قطع غيار أصلية, ورشة دراجات نارية, محرك دراجة, فرامل دراجة, إطارات موتور, زيت محرك, فلاتر دراجات, بطاريات دراجات, سلاسل دراجات, شمعات احتراق, كفرات دراجات',
            'en' => 'motorcycle parts, bike repair, motor fixing, genuine parts, motorcycle workshop, engine parts, bike brakes, motorcycle tires, engine oil, motorcycle filters, bike batteries, motorcycle chains, spark plugs, bike covers, spare parts'
        ],
        'image' => '/assets/images/og-motorcycle-shop.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Product-Specific Defaults
    |--------------------------------------------------------------------------
    */

    'product' => [
        'default_currency' => 'USD',
        'default_availability' => 'InStock',
        'brand_options' => [
            'Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Ducati',
            'BMW', 'Harley-Davidson', 'KTM', 'Triumph', 'Royal Enfield'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Common Categories (for breadcrumbs & keywords)
    |--------------------------------------------------------------------------
    */

    'categories' => [
        'ar' => [
            'engine' => 'قطع المحرك',
            'brakes' => 'الفرامل',
            'tires' => 'الإطارات',
            'electrical' => 'الأجزاء الكهربائية',
            'filters' => 'الفلاتر',
            'oils' => 'الزيوت والشحوم',
            'chains' => 'السلاسل',
            'accessories' => 'الإكسسوارات',
        ],
        'en' => [
            'engine' => 'Engine Parts',
            'brakes' => 'Brake Systems',
            'tires' => 'Tires & Wheels',
            'electrical' => 'Electrical Components',
            'filters' => 'Filters',
            'oils' => 'Oils & Lubricants',
            'chains' => 'Chains & Sprockets',
            'accessories' => 'Accessories',
        ],
    ],

];
