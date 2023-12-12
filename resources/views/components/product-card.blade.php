<div class="single-product">
    <div class="product-image">
        <img src="{{ asset($product->image_url) }}" alt="Product_Photo">
        @if ($product->sale_percentage)
        <span class="sale-tag">-{{ $product->sale_percentage }}%</span>
        @endif
        <div class="button">
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <input type="hidden" name="quantity" value="1" />
                <button type="submit" class="btn"><i class="lni lni-cart"></i> {{ __('Add To
                Cart') }}</button>
            </form>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{ $product->category->name }}</span>
        <h4 class="title">
            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{ CurrencyFormat::format($product->price) }}</span>
            @if ($product->compare_price)
            <span class="discount-price">{{ CurrencyFormat::format($product->compare_price) }}</span>
            @endif
        </div>
    </div>
</div>
