@extends('layouts.dashboardLayout')
@section('title', $product->name . ' details')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">{{ $product->name }}</li>
@endsection

@section('content')

@if($options !== null)
@foreach($options as $option)
<div class="m-3">
    <strong>{{ $option->name }}:</strong>
    <span>{{ $option->value }}</span>
</div>
@endforeach
@else
<div class="m-3">
    <strong>No options for this product</strong>
</div>
@endif

@endsection