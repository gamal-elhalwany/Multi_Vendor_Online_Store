@extends('layouts.dashboardLayout')

@section('title', 'Edit Counpon')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Counpon</li>
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Coupon</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('coupons.index') }}"> Back </a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong>Something went wrong.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="code" value="{{ $coupon->code }}" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ $coupon->name }}" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Store:</strong>
                <select name="store_id" class="form-control">
                    @foreach($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Max Uses:</strong>
                <input type="number" name="max_uses" value="{{ $coupon->max_uses }}" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>User Max Uses:</strong>
                <input type="number" name="user_max_uses" value="{{ $coupon->user_max_uses }}" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Discount Type:</strong>
                <select name="type" class="form-control">
                    <option value="persentage">Persentage</option>
                    <option value="fixed">Fixed</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Discount Amount:</strong>
                <input type="text" value="{{ $coupon->discount_amount }}" class="form-control" name="discount_amount" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Start Date:</strong>
                <input type="date" class="form-control" name="start_at" value="{{ $coupon->start_at }}" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>End Date:</strong>
                <input type="date" class="form-control" name="end_at" value="{{ $coupon->end_at }}" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Coupon Status:</strong>
                <select class="coupon-status form-control" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 text-center">
            <button type="submit" class="btn btn-primary form-control mb-4 mt-4">Update Coupon</button>
        </div>
    </div>
</form>
@endsection