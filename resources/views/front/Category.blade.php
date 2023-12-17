<x-front-layout title="{{ config('app.name') }}">
    @section('breadcrumbs')
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Category: {{ $category->name }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('product.index') }}">Shop</a></li>
                            <li>Shop Department</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <!-- Start Products Grid -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget search">
                            <h3>Search Product</h3>
                            <form action="{{ route('product.index') }}" method="get">
                                <input type="text" name="name" placeholder="Search Here..."
                                    :value="$request - > name">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        {{-- <div class="single-widget">
                            <h3>All Categories</h3>
                            <ul class="list">
                                <li>
                                    <a href="product-grids.html">Computers &amp; Accessories </a><span>(1138)</span>
                                </li>
                            </ul>
                        </div> --}}
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget range">
                            <h3>Price Range</h3>
                            <form action="{{ route('filter.products.byRange') }}" method="GET">
                                <input type="range" class="form-range" name="range" step="1" min="100"
                                    max="10000" value="10" onchange="rangePrimary.value=value">
                                <div class="range-inner">
                                    <label>$</label>
                                    <input type="text" id="rangePrimary" name="range_value" placeholder="100" value="0">
                                </div>
                                <button type="submit" class="btn btn-outline-primary m-3">Apply Filter</button>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                    <div class="product-sorting">
                                        <form action="{{ route('sort.products') }}" method="GET">
                                            <label for="sorting">Sort by:</label>
                                            <select class="form-control" id="sorting"name="criteria"
                                                onchange="this.form.submit()">
                                                <option value="popularity">Popularity</option>
                                                <option value="average_rating">Average Rating</option>
                                                <option value="low_high">Low - High Price</option>
                                                <option value="high_low">High - Low Price</option>
                                                <option value="a_z">A - Z Order</option>
                                                <option value="z_a">Z - A Order</option>
                                            </select>
                                            <h3 class="total-show-product">Showing: <span>1 - 12 items</span></h3>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="lni lni-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">
                                    @foreach ($category->products as $product)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Start Single Product -->
                                            <div class="single-product">
                                                <div class="product-image">
                                                    <img src="{{ $product->image_url }}" alt="#">
                                                    <div class="button">
                                                        <form action="{{ route('cart.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}" />
                                                            <input type="hidden" name="quantity" value="1" />
                                                            <button type="submit" class="btn"><i
                                                                    class="lni lni-cart"></i>
                                                                {{ __('Add To Cart') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <span class="category">{{ $product->category->name }}</span>
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Single Product -->
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <div class="row">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                {{ $category->products->links() }}
                                            </ul>
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div> --}}
                            </div>

                            <div class="tab-pane fade" id="nav-list" role="tabpanel"
                                aria-labelledby="nav-list-tab">
                                <div class="row">
                                    @foreach ($category->products as $product)
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <!-- Start Single Product -->
                                            <div class="single-product">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <div class="product-image">
                                                            <img src="{{ $product->image_url }}" alt="#">
                                                            <div class="button">
                                                                <form action="{{ route('cart.store') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}" />
                                                                    <input type="hidden" name="quantity"
                                                                        value="1" />
                                                                    <button type="submit" class="btn"><i
                                                                            class="lni lni-cart"></i>
                                                                        {{ __('Add To Cart') }}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-12">
                                                        <div class="product-info">
                                                            <span
                                                                class="category">{{ $product->category->name }}</span>
                                                            <h4 class="title">
                                                                <a
                                                                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Single Product -->
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <div class="row">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                {{ $categoryPaginate->products->links() }}
                                            </ul>
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products Grid -->

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

</x-front-layout>
