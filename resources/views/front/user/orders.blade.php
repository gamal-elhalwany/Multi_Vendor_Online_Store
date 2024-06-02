<x-front-layout title="Orders">
    <!-- Start Breadcrumbs -->
    @section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Orders</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('product.index') }}">Shop</a></li>
                        <li>orders</li>
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
                <h4>Here are your orders. Welcome {{ auth()->user()->name }}!</h4>
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Order Number</th>
                            <th scope="col">Order Payment Method</th>
                            <th scope="col">Order Payment Status</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Created at</th>
                            <th scope="col" colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ ($order->created_at->diffForHumans()) }}</td>
                            <td>
                                @if($order->payment_status == 'pending' || $order->payment_status == 'failed')
                                <a href="{{ url('/payments/paypal', $order->id) }}" class="btn btn-outline-primary">Pay
                                    with
                                    PayPal</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.orders.items', ['username' => auth()->user()->name, 'order' => $order->id]) }}" class="btn btn-outline-primary">Order's
                                    items</a>
                            </td>
                        </tr>
                        @empty
                        <h5 class="mt-3">You have no orders!</h5>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-front-layout>