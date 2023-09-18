@extends('layouts.dashboardLayout')

@section('title', 'Trashed Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')

    <x-alert type="success" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <input type="text" name="name" class="form-control mx-2" placeholder="Filter Categories" :value="request('name')">
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button type="submit" class="btn btn-dark mx-2 form-control">Search</button>
    </form>

    <div class="mb-5">
        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary m-3">Back</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="Image" height="50">
                    </td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>
                        <form action="{{ route('categories.restore', $category->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-outline-info btn-sm">Restore</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('categories.force-delete', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Categories Defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- If your app uses a bootstrap as css framework and this method doesn't work with you go to the appServiceProvider and call for this method:Paginator::useBootstrap(); --}}
    {{ $categories->withQueryString()->links() }}

@endsection
