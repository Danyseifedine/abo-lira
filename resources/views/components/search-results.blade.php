@forelse($products as $product)
<x-product-slide
    :slug="$product->slug"
    :primaryImage="$product->image"
    :name="$product->name"
    :description="$product->description"
    :category="$product->category"
    :quality="$product->quality"
    :hasMultipleVariants="$product->has_multiple_variants"
    :is_discounted="$product->is_discounted"
    :basePrice="number_format($product->base_price, 2)"
    :price="number_format($product->price, 2)"
    :oldPrice="$product->discount_percentage > 0 ? number_format($product->base_price, 2) : null"
    :discountPercentage="$product->discount_percentage > 0 ? round($product->discount_percentage) : null" 
    :isForSearch="true"
    />
@empty
<div class="search-result-item">
    <p>{{ app()->getLocale() === 'ar' ? 'لا يوجد منتجات مطابقة للبحث' : 'No products found' }}</p>
</div>
@endforelse