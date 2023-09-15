@extends('layouts.dashboardLayout')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
    <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}"/>
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>Category Parent</label>
            <select class="form-control form-select" name="parent_id">
                <option value="">Primary Category</option>
                @foreach ($categories as $parent)
                    <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->parent_id)>{{ $parent->name }}</option>
                @endforeach
            </select>
            @error('parent_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control"/>
            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            @if ($category->image)
            <img src="{{ asset('storage/' .$category->image) }}" alt="Image" height="50">
            @endif
        </div>

        <div class="form-group">
            <label for="">Status</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="radio" aria-label="Radio button for following text input" name="status" value="active" @checked($category->status == 'active')>
                    </div>
                </div>
                <label>Active</label>
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="radio" aria-label="Radio button for following text input" name="status" value="archived" @checked($category->status == 'archived')>
                    </div>
                </div>
                <label>Archive</label>
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
