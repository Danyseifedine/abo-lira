    <div class="minicart__product">
        @forelse($cartItems as $item)
        <x-minicart-item
            :image="$item->image"
            :name="$item->name"
            :nameAr="$item->name_ar"
            :variants="$item->variants"
            :variantsAr="$item->variants_ar"
            :currentPrice="$item->total"
            :quantity="$item->quantity"
            :link="route('detail', ['slug' => $item->slug])"
            :itemId="$item->id" />
        @empty
        <div class="minicart__product--empty" style="padding-top: 150px; text-align: center;">
            <p>{{ __('nav.no_items_in_cart') }}</p>
        </div>
        @endforelse
        <div class="minicart__product--empty" id="minicart-empty-container" style="display: none; padding-top: 150px; text-align: center;">
            <p>{{ __('nav.no_items_in_cart') }}</p>
        </div>
    </div>