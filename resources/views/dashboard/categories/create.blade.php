@extends('layouts.dashboardLayout')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Create Category</li>
@endsection

@section('content')
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-control" />
        </div>

        <div class="form-group">
            <label>Category Parent</label>
            <select class="form-control form-select" name="category_name">
                <option value="">Primary Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control"/>
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
                        <input type="radio" aria-label="Radio button for following text input" name="status" value="archive">
                    </div>
                </div>
                <label>Archive</label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
