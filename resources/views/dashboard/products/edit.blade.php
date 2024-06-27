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
        <select class="form-control form-select" name="category_id">
            <option value="">Category</option>
            <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
        </select>
        @error('category_id')
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
        <label for="images">Product's gallery</label>
        <input type="file" name="images[]" class="form-control @error('images[]') is-invalid @enderror" multiple>
        @error('images[]')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        @if ($product->images)
        @foreach($product->images as $image)
        <img src="{{ asset('storage/' .$image->image_path) }}" alt="Image" height="50">
        @endforeach
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
        <textarea name="compare_price" class="form-control">{{ $product->compare_price }}</textarea>
        @error('compare_price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Quantity</label>
        <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" value="{{ $product->qty }}" min="1">
        @error('qty')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Product Store</label>
        <select class="form-control" name="store_id">
            <option value="">Select Store</option>
            @foreach ($stores as $store)
            <option value="{{ $store->id }}">
                {{ $store->name }}
            </option>
            @endforeach
        </select>
        @error('store_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Tags</label>
        <input name="tags" class="form-control" placeholder="update the product tags..." value="{{ $tags }}">
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
        <h2>Enter Product Options</h2>
        <div id="options">
            <div class="option-container">
                @if($options !== null)
                <p class="alert alert-danger">The product already has its options, if you don't enter new options or re-enter the old product's options you'll lose these options, so take care, please.</p>
                <input class="form-control mb-3" type="text" name="options[0][name]" placeholder="Option Name">
                <input class="form-control mt-3" type="text" name="options[0][value]" placeholder="Option Value">
                <button class="remove-option btn btn-danger mt-3 mb-3">Remove Option</button>
                @endif

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

<script>
    let optionIndex = 1;
    document.getElementById('addOption').addEventListener('click', function(e) {
        e.preventDefault();
        const optionsDiv = document.getElementById('options');
        const newOption = document.createElement('div');
        newOption.classList.add('option-container');
        newOption.innerHTML = `
            <input class="form-control mb-3" type="text" name="options[${optionIndex}][name]" placeholder="Option Name">
            <input class="form-control mt-3" type="text" name="options[${optionIndex}][value]" placeholder="Option Value" >
            <span class="remove-option btn btn-danger mt-3 mb-3">Remove Option</span>
        `;
        optionsDiv.appendChild(newOption);
        optionIndex++;
    });

    document.getElementById('options').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-option')) {
            event.target.parentElement.remove();
        }
    });
</script>
@endsection