@extends('layouts.dashboardLayout')

@section('title', 'Create Product')
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Create Product</li>
@endsection

@section('content')
<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="">Product Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Product Store</label>
        <select class="form-control form-select @error('store_id') is-invalid @enderror" name="store_id">
            <option value="">Primary store</option>
            @foreach ($stores as $store)
            <option value="{{ $store->id }}">{{ $store->name }}</option>
            @endforeach
        </select>
        @error('store')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Product Category</label>
        <select class="form-control form-select @error('category_id') is-invalid @enderror" name="category_id">
            <option value="">Primary Category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" />
        @error('image')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Price</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="10">
        @error('price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Compare Price</label>
        <input type="number" name="compare_price" class="form-control @error('compare_price') is-invalid @enderror" value="{{ old('compare_price') }}" min="10">
        @error('compare_price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Quantity</label>
        <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty') }}" min="1">
        @error('qty')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Status</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="active" checked>
                </div>
            </div>
            <label>Active</label>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="draft">
                </div>
            </div>
            <label>Draft</label>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" aria-label="Radio button for following text input" name="status" value="archived">
                </div>
            </div>
            <label>Archive</label>
        </div>
        @error('status')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Tags</label>
        <input name="tags" class="form-control" placeholder="Add the product tags...">
        @error('tags')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <h2>Enter Product Options</h2>
        <div id="options">
            <div class="option-container">
                <input class="form-control mb-3" type="text" name="options[name]" placeholder="Option Name">
                <input class="form-control mt-3" type="text" name="options[value]" placeholder="Option Value">
                <button class="remove-option btn btn-danger mt-3 mb-3">Remove Option</button>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-dark" id="addOption">Add Option</button>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection