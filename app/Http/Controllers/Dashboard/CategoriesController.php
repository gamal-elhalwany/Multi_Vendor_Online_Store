<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list', ['only' => ['index']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    protected function uploadImage (Request $request) {
        // You Have to run this command first to make the laravel storage linked with the public path:php artisan storage:link

        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', 'public');
        return $path;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Comment:- This is another way to filtering data without scopes.
        // $query = Category::query();
        // if ($name = $request->query('name')) {
        //     $query->where('name', 'LIKE', "%$name%");
        // }
        // if ($status = $request->query('status')) {
        //     $query->where('status', '=', $status);
        // }

        // this filter() method is the name of the Scope of Category Model.
        $categories = Category::filter($request->all())->orderby('name')
        // this parent value is coming from the Model Category public function parent that makes the relationship.
        ->with('parent')
        ->withCount([
            'products'
            //Comment:- this goes when you want to get a specific rows with specific conditions.
            // 'products' => function ($query) {
            //     $query->where('status', '=', 'archived');
            // }
        ])
        ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::where('id', '<>', $id)->where(function ($query) use ($id) {
            $query->whereNull('parent_id')->orWhere('parent_id', '<>', $id);
        })->get();

        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $old_image = $category->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('categories.index')->with([
            'success', 'Category Updated Successfully!',
            'updated_id' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage called soft-delete.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category Moved to Trash Successfully!');
    }

    /**
     * View Trashed Categories.
     */
    public function trash () {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }

    /**
     * Restore a specific category.
     */
    public function restore (Request $request, $id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')->with('success', 'Category Restored!');
    }

    /**
     * Remove the specified resource from categories table forever called [force-delete].
     */
    public function forceDelete (Request $request, $id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        // this if statement is for deleting the image after deleting the category and don't leave it.
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('categories.trash')->with('success', 'Category Deleted Successfully!');
    }
}
