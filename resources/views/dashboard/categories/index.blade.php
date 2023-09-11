@extends('layouts.dashboardLayout')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

<table class="table">
    <a href="{{ route('categories.create') }}" class="btn btn-outline-primary m-3">Create Category</a>
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent_Id</th>
            <th>Created At</th>
            <th>Actions</th>
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
                <a href="{{ route('category.edit') }}" class="btn btn-outline-primary.btn-sm">Edit</a>
                <form action="{{ route('category.destroy') }}" method="post">
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
