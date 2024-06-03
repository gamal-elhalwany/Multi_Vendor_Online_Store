<x-front-layout title="Wishlist">
    <!-- Start Breadcrumbs -->
    @section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ auth()->user()->name }} - Wishlist</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('product.index') }}">Shop</a></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <!-- End Breadcrumbs -->
    <x-alert type="success" />
    <x-alert type="error" />
    <x-alert type="alert" />

    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">

                <div class="container">
                    <div class="cart-list-head">
                        <!-- Cart List Title -->
                        <div class="cart-list-title">
                            <div class="row">
                                <div class="col-lg-1 col-md-1 col-12">
                                    #
                                </div>
                                <div class="col-lg-4 col-md-3 col-12">
                                    <p>Product Name</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>Quantity</p>
                                </div>
                                <div class="col-lg-1 col-md-2 col-12">
                                    <p>Remove</p>
                                </div>
                            </div>
                        </div>
                        <!-- End Cart List Title -->
                        <!-- Cart Single List list -->
                        @foreach ($wishlists as $list)
                        <div class="cart-single-list" id="cart_id">
                            <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-12">
                                    <a href="{{ route('product.show', $list->product->slug) }}"><img
                                            src="{{ $list->product->image_url }}" alt="#"></a>
                                </div>
                                <div class="col-lg-4 col-md-3 col-12">
                                    <h5 class="product-name">
                                        <a href="{{ route('product.show', $list->product->slug) }}">
                                            {{ $list->product->name }}
                                        </a>
                                    </h5>
                                    <p class="product-des">
                                        <span><em>Price:</em> {{$list->product->price}}</span>
                                        <span><em>Color:</em> Black</span>
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <div class="count-input">
                                        <form action="{{ route('cart.update', $list->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input class="form-control item-qty" data-id="{{ $list->id }}"
                                                value="{{ $list->quantity }}" name="quantity"
                                                {{ session('coupon_code') ? 'disabled' : '' }}
                                                onchange="this.form.submit()">
                                            @error('quantity')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </form>
                                        <input type="hidden" class="product_id" name="productID" id="product_id"
                                            value="{{ $list->product_id }}">
                                        @error('productID')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <input type="hidden" class="product_price" value="{{ $list->product->price }}">
                                        <input type="hidden" id="x-csrf" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12 total-cart-price-wrapper">
                                    <p class="totalCartPrice {{ $list->product_id }}" id="{{ $list->product_id }}">
                                        {{ CurrencyFormat::format($list->quantity * $list->product->price) }}
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    @if(session('coupon_code'))

                                    @if(session('fixed_amount'))
                                    <p class="discount_amount">{{ session('fixed_amount') }}</p>
                                    @elseif(session('percent_amount'))
                                    <p class="discount_amount">{{ session('percent_amount') . '%' }}</p>
                                    @else
                                    <p class="discount_amount">0.00</p>
                                    @endif

                                    @else
                                    <p class="discount_amount">0.00</p>
                                    @endif
                                </div>
                                <div class="col-lg-1 col-md-2 col-12">
                                    @if(session()->has('coupon_code'))
                                    @else
                                    <div class="remove_wrapper">
                                        <input type="hidden" id="d-csrf" value="{{ csrf_token() }}">
                                        <a class="remove-item" data-id="{{ $list->id }}"
                                            onclick="return confirm('Are you sure you want to delete this item from the cart?')"
                                            href="javascript:void(0)">
                                            <i class="lni lni-close"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- End Single List list -->
                    </div>

                </div>
            </div>
    </section>
</x-front-layout>