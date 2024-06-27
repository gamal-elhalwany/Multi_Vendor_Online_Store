<x-front-layout :title="$product->name">
    @section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('product.index') }}">Shop</a></li>
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="{{ $product->image_url }}" id="current" alt="#">
                                </div>
                                <div class="images">
                                    @if ($product->images)
                                    @foreach($product->images as $image)
                                    <img src="{{ asset('storage/' .$image->image_path) }}" alt="Image">
                                    @endforeach
                                    @endif
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{ $product->name }}</h2>
                            <p class="category">
                                <i class="lni lni-tag"></i>
                                {{ $product->tag }}:
                                <a href="{{ route('category.show', $product->category->slug) }}">
                                    {{ $product->category->name }}
                                </a>
                            </p>
                            <h3 class="price">
                                {{ CurrencyFormat::format($product->price) }}
                                @if ($product->compare_price)
                                <span>{{ CurrencyFormat::format($product->compare_price) }}</span>
                                @endif
                            </h3>
                            <p class="info-text">
                                {{ $product->descrtipion }}
                            </p>
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group color-option">
                                            <label class="title-label" for="size">{{ __('Choose color') }}</label>
                                            <div class="single-checkbox checkbox-style-1">
                                                <input type="checkbox" id="checkbox-1" checked="">
                                                <label for="checkbox-1"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-2">
                                                <input type="checkbox" id="checkbox-2">
                                                <label for="checkbox-2"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3">
                                                <label for="checkbox-3"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-4">
                                                <input type="checkbox" id="checkbox-4">
                                                <label for="checkbox-4"><span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="color">Battery capacity</label>
                                            <select class="form-control" id="color">
                                                <option>5100 mAh</option>
                                                <option>6200 mAh</option>
                                                <option>8000 mAh</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="color">Quantity</label>
                                            <select class="form-control" name="quantity">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="button cart-button">
                                                <button class="btn" type="submit" style="width: 100%;">
                                                    <i class="lni lni-cart"></i>
                                                    Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="wish-button">
                                    <form action="{{ route('user.wishlist.store', auth()->user()->name) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <button type="submit" class="btn mt-3"><i class="lni lni-heart"></i>
                                            {{ __('To Wishlist') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Details or Description</h4>
                                <p style="word-wrap:break-word;">{{$product->description}}</p>
                                <h4>Shipping Options:</h4>
                                <ul class="normal-list">
                                    <li><span>Courier:</span> 2 - 4 days, $22.50</li>
                                    <li><span>Local Shipping:</span> up to one week, $10.00</li>
                                    <li><span>UPS Ground Shipping:</span> 4 - 6 days, $18.00</li>
                                    <li><span>Unishop Global Export:</span> 3 - 4 days, $25.00</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info-body">
                                <h4>Specifications</h4>
                                <ul class="normal-list">
                                    @if($options !== null)
                                    @foreach($options as $option)
                                    <li><span><strong>{{$option->name}}:</strong></span> {{$option->value}}</li>
                                    @endforeach
                                    @else
                                    <li>No Options for this product yet.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="single-block give-review">
                            <h4>Overall ({{round($product->ratings->avg('rating'), 3)}})</h4>
                            <ul>
                                <li>
                                    @for($i = 1; $i <= round($product->ratings->avg('rating')); $i++)
                                        <i class="lni lni-star-filled"></i>
                                        @endfor
                                        @for($i = 0; $i < floor(5 - $product->ratings->avg('rating')); $i++)
                                            <i class="lni lni-star-empty"></i>
                                            @endfor
                                </li>
                            </ul>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn review-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Leave a Review
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="single-block">
                            <div class="reviews">
                                <h4 class="title">Latest Reviews</h4>
                                <!-- Start Single Review -->
                                @if($product->ratings->count() > 0)
                                @foreach($product->ratings()->latest()->get() as $rating)
                                <div class="single-review">
                                    <img src="{{auth()->user()->photo}}" alt="#">
                                    <div class="review-info">
                                        <h4>{{$rating->review}}
                                            <span>By {{$rating->user->name}}</span>
                                        </h4>
                                        <ul class="stars">
                                            @for($i = 0; $i < $rating->rating; $i++)
                                                <li><i class="lni lni-star-filled"></i></li>
                                                @endfor
                                                @for($i = 0; $i < (5 - $rating->rating); $i++)
                                                    <li><i class="lni lni-star-empty"></i></li>
                                                    @endfor
                                                    Rating
                                        </ul>
                                        <p>{{$rating->created_at->diffForHumans()}}</p>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p>No reviews yet</p>
                                @endif
                                <!-- End Single Review -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->

    <x-alert type="success" />

    <!-- Review Modal -->
    <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ratings.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-name">Your Name</label>
                                    <input class="form-control" type="text" id="review-name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-email">Your Email</label>
                                    <input class="form-control" type="email" id="review-email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="review-rating">Rating</label>
                                    <select class="form-control" name="rating" id="review-rating">
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                    @error('rating')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review-message">Review</label>
                            <textarea class="form-control" name="review" id="review-message" rows="8"></textarea>
                            @error('review')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer button">
                        <button type="submit" class="btn">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Review Modal -->

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript">
        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                //reset opacity
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                //adding class
                //current.classList.add("fade-in");
                //opacity
                e.target.style.opacity = opacity;
            });
        });
    </script>
    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    @endpush
</x-front-layout>