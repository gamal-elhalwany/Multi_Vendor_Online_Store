<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        @auth
        <span class="total-items">{{ Auth::user()->carts()->count() }}</span>
        @else
        <span class="total-items">0</span>
        @endauth
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            @auth
            <span>
                {{ Auth::user()->carts()->count() . ' ' . __('Items') }}
            </span>
            @if (auth()->user()->carts()->count())
            <a href="{{ route('cart.index') }}" Route::currentRouteName()=='cart.index' ?
                onclick="event.preventDefault();" style="pointer-events: none; opacity: 0.5;" : ''>
                {{ __('Total Items') }}
            </a>
            @endif
            @endauth
        </div>
        <ul class="shopping-list">
            @foreach ($items as $cart)
            @if ($cart->user_id == null)
            <li>
                <a href="javascript:void(0)" class="remove" title="Remove this item"><i class="lni lni-close"></i></a>
                <div class="cart-img-head">
                    <a class="cart-img" href="{{ route('cart.index', $cart->product->slug) }}">
                        <img src="{{ $cart->product->image_url }}" alt="#">
                    </a>
                </div>

                <div class="content">
                    <h4>
                        <a href="{{ route('show', $product->id) }}">
                            {{ $cart->product->name }}
                        </a>
                    </h4>
                    <p class="quantity">{{ $cart->quantity }}x - <span
                            class="amount">{{ CurrencyFormat::format($cart->product->price) }}</span></p>
                </div>
            </li>
            @endif
            @endforeach
        </ul>
        <div class="bottom">
            @auth
            @if (auth()->user()->carts()->count())
            <div class="total">
                <span>{{ __('Total') }}</span>
                <span class="total-amount">{{ CurrencyFormat::format($total) }}</span>
            </div>
            <div class="button">
                <a href="{{ route('cart.index') }}" class="btn animate" @if(Route::currentRouteName()=='cart.index' )
                    onclick="event.preventDefault();" style="pointer-events: none; opacity: 0.5;" @endif>
                    {{ __('Cart') }}
                </a>
            </div>
            <!-- <div class="button">
                <a href="{{ route('checkout.create') }}" class="btn animate">
                    {{ __('Checkout') }}
                </a>
            </div> -->
            @endif
            @endauth
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>