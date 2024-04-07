@extends('layouts.dashboardLayout')

@section('title', 'Coupons')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Coupons</li>
@endsection

@section('content')

<x-alert type="success" />

<div class="mb-5">
    <a href="{{ route('coupons.create') }}" class="btn btn-outline-primary m-3">Create a New Coupon</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Store</th>
            <th>Status</th>
            <th>Starts at</th>
            <th>Ends at</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($coupons as $coupon)
        <tr>
            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->name }}</td>
            <td>{{ $coupon->type }}</td>
            <td>amountPlacehloder</td>
            <td>{{ $coupon->store_id }}</td>
            <td>{{ $coupon->status }}</td>
            <td>{{ $coupon->start_at }}</td>
            <td>{{ $coupon->end_at }}</td>
            <td>
                <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fas-pencil"></i>
                </a>
            </td>
            <td>
                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fas-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">No coupons Defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- If your app uses a bootstrap as css framework and this method doesn't work with you go to the appServiceProvider and call for this method:Paginator::useBootstrap(); -->
<!--  $coupons->links  -->

@endsection