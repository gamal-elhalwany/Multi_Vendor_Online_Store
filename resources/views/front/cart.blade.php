<x-front-layout title="Cart">

    <!-- Start Breadcrumbs -->
    @section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cart</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('product.index') }}">Shop</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <!-- End Breadcrumbs -->

    <!-- Start Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->
                <!-- Cart Single List list -->
                @foreach ($carts as $cart)
                <div class="cart-single-list" id="{{ $cart->id }}">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-md-1 col-12">
                            <a href="{{ route('product.show', $cart->product->slug) }}"><img src="{{ $cart->product->image_url }}" alt="#"></a>
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <h5 class="product-name">
                                <a href="{{ route('product.show', $cart->product->slug) }}">
                                    {{ $cart->product->name }}
                                </a>
                            </h5>
                            <p class="product-des">
                                <span><em>Type:</em> Mirrorless</span>
                                <span><em>Color:</em> Black</span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="count-input">
                                <input class="form-control item-qty" data-id="{{ $cart->id }}" value="{{ $cart->quantity }}" name="quantity">
                                @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input type="hidden" class="product_id" name="productID" id="product_id" value="{{ $cart->product_id }}">
                                @error('productID')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input type="hidden" class="product_price" value="{{ $cart->product->price }}">
                                <input type="hidden" id="x-csrf" value="{{ csrf_token() }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p class="totalCartPrice" data-id="{{ $cart->id }}">
                                {{ CurrencyFormat::format($cart->quantity * $cart->product->price) }}
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ CurrencyFormat::format(0) }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <input type="hidden" id="d-csrf" value="{{ csrf_token() }}">
                            <a class="remove-item" data-id="{{ $cart->id }}" href="javascript:void(0)"><i class="lni lni-close"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End Single List list -->
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <x-alert type="error" />
                                        <form action="{{ route('apply.discount') }}" method="POST">
                                            @csrf
                                            <input name="coupon_code" id="coupon_code" placeholder="{{__('Enter Your Coupon')}}">
                                            <div class="button">
                                                <button class="btn" id="apply_coupon">{{ __('Apply Coupon Code') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        @if (auth()->user()->carts()->count())
                                        @foreach ($carts as $cart)
                                        <li>Cart
                                            Subtotal<span>{{ CurrencyFormat::format($cartTotal = $cart->product->price * $cart->quantity) }}</span>
                                        </li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>${{ $discount = $cartTotal - 10 * 350 }}</span></li>
                                        <li class="last">You
                                            Pay<span>{{ CurrencyFormat::format($cartTotal - $discount) }}</span>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('checkout.store') }}" class="btn">Checkout</a>
                                        <a href="{{ route('product.index') }}" class="btn btn-alt">Continue
                                            shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Shopping Cart -->
    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    @endpush
</x-front-layout>