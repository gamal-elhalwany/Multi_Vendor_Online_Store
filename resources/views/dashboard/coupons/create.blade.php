@extends('layouts.dashboardLayout')

@section('title', 'Create Counpons')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Create Counpons</li>
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create a New Coupon</h2>
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

<form action="{{ route('coupons.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="code" placeholder="Counpon Code" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Counpon name" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Store:</strong>
                <select name="store_id" class="form-control">
                    <option value="">Store Name</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Max Uses:</strong>
                <input type="number" name="max_uses" placeholder="Coupon Max Uses" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>User Max Uses:</strong>
                <input type="number" name="user_max_uses" placeholder="User Max Uses" class="form-control" />
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
                <input type="text" placeholder="discount amount" class="form-control" name="discount_amount" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Min Amount:</strong>
                <input type="text" placeholder="Min amount" class="form-control" name="min_amount" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Start Date:</strong>
                <input type="date" class="form-control" name="start_at" placeholder="Starts at" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>End Date:</strong>
                <input type="date" class="form-control" name="end_at" placeholder="Ends at" />
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
        <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 text-center">
            <button type="submit" class="btn btn-primary form-control mb-4 mt-4">Create Coupon</button>
        </div>
    </div>
</form>
@endsection