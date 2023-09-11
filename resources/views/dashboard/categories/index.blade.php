@extends('layouts.dashboardLayout')

@section('breadcrumb')
    @parent
    <h1 class="breadcrumb-item active">Categories</h1>
@endsection

@section('content')

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <a href="{{ route('categories.create') }}" class="btn btn-outline-primary m-3">Create Category</a>
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent_Id</th>
            <th>Created At</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
        <tr>
            <td>{{ $category->image }}</td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            </td>
            <td>
                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td>No Categories Defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
