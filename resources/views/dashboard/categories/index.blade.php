@extends('layouts.dashboardLayout')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
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
        <a href="{{ route('categories.create') }}" class="btn btn-outline-primary m-3">Create Category</a>
        <a href="{{ route('categories.trash') }}" class="btn btn-outline-dark m-3">Trash</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent_Category</th>
                <th>Products #</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr id="category_{{ $category->id }}">
                    <td>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="Image" height="50">
                    </td>
                    <td>{{ $category->id }}</td>
                    <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                    {{-- The optional() function is used to handle cases where a category may not have a parent, preventing any potential errors. --}}
                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                    <td>{{ $category->parent_count }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="btn btn-outline-primary btn-sm">Edit</a>
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
                    <td colspan="9">No Categories Defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- If your app uses a bootstrap as css framework and this method doesn't work with you go to the appServiceProvider and call for this method:Paginator::useBootstrap(); --}}
    {{ $categories->withQueryString()->links() }}

    @if ($message = Session::get('updated_id'))
    <script>
        $updatedEle = {{ $message }}
        function addClass () {
            let $ele = document.getElementById('category_'+$updatedEle);
            $ele.className += "table-info";
            console.log($ele);
        }
        addClass();
    </script>
    @endif

@endsection
