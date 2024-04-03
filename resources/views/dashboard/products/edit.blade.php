@extends('layouts.dashboardLayout')

@section('title', 'Edit Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')
<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="">Product Name</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" />
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Category</label>
        <select class="form-control form-select" name="category">
            <option value="">Category</option>
            <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
        </select>
        @error('product')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control" />
        @error('image')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        @if ($product->image)
        <img src="{{ asset('storage/' .$product->image) }}" alt="Image" height="50">
        @endif
    </div>

    <div class="form-group">
        <label for="">Price</label>
        <textarea name="price" class="form-control">{{ $product->price }}</textarea>
        @error('price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Compare Price</label>
        <textarea name="compare-price" class="form-control">{{ $product->compare_price }}</textarea>
        @error('compare-price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Product Store</label>
        <select name="store">
            <option value="{{ $product->store }}">
                {{ $product->store->name }}
            </option>
        </select>
        @error('store')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Tags</label>
        <input name="tags" class="form-control" placeholder="create some tags..." value="{{ $tags }}">
        @error('tags')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Status</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="active" @checked($product->status == 'active')>
                </div>
            </div>
            <label>Active</label>

            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="archived" @checked($product->status == 'archived')>
                </div>
            </div>
            <label>Archive</label>

            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="draft" @checked($product->status == 'draft')>
                </div>
            </div>
            <label>Draft</label>
        </div>
        @error('status')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection