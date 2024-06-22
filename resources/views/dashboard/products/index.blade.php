@extends('layouts.dashboardLayout')

@section('title', 'Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<x-alert type="success" />

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <input type="text" name="name" class="form-control mx-2" placeholder="Filter products" :value="old(request('name'))">
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="archived" @selected(request('status')=='archived' )>Archived</option>
        <option value="draft" @selected(request('status')=='draft' )>Draft</option>
    </select>
    <button type="submit" class="btn btn-dark mx-2 form-control">Search</button>
</form>

<div class="mb-5">
    <a href="{{ route('products.create') }}" class="btn btn-outline-primary m-3">Add Product</a>
    {{-- <a href="{{ route('products.trash') }}" class="btn btn-outline-dark m-3">Trash</a> --}}
</div>

<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $product->image) }}" alt="Image" height="50">
            </td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store_id }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            </td>
            <td>
                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </td>
            <td>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-info btn-sm">Show</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">No products Defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- If your app uses a bootstrap as css framework and this method doesn't work with you go to the appServiceProvider and call for this method:Paginator::useBootstrap(); --}}
{{ $products->withQueryString()->links() }}

@endsection