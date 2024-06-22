<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use App\Models\HeroSlider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-product', ['only' => ['index']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:show-product', ['only' => ['show']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
        $this->middleware('permission:create-product', ['only' => ['createSlider', 'storeSlider']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Comment:- almost the same code in the global scope file but we here just used the product model instead its query builder facade.
        // $user = auth()->user();
        // if ($user->store_id) {
        //     $products = Product::where('store_id', '=', $user->store_id)->paginate();
        // } else {
        //    $products = Product::paginate();
        // }

        // I used the global scope instead of the above code and instead of repeating it every time.
        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            $products = Product::filter($request->all())->latest()->orderby('name')->paginate();
            return view('dashboard.products.index', compact('products'));
        }
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            $stores = $user->stores;
            $categories = Category::all();
            return view('dashboard.products.create', compact('stores', 'categories'));
        }
        return redirect()->route('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'              => ['required', 'min:3', 'max:100'],
            'description'       => ['required', 'min:100', 'max:255'],
            'qty'               => ['required'],
            'price'             => ['required', 'numeric'],
            'image'             => ['required', 'mimes:jpg,jpeg,png,webp'],
            'category_id'       => ['required', Rule::exists('categories', 'id')],
            'store_id'          =>  'required|exists:stores,id',
        ]);

        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            if (!$request->hasFile('image')) {
                return;
            }
            $file = $request->file('image');
            $path = $file->store('uploads/products', 'public');


            $data = $request->all();
            $data['image'] = $path;
            $options = json_encode($request->post('options'));
            $data['options'] = $options;

            $tag_ids = [];
            if ($request->post('tags')) {
                $tags = json_decode($request->post('tags'));
                $allTags = Tag::all();
                foreach ($tags as $tag_name) {
                    $slug = Str::slug($tag_name->value);
                    $tag = $allTags->where('slug', $slug)->first();
                    if (!$tag) {
                        $tag = Tag::create([
                            'name' => $tag_name->value,
                            'slug' => $slug,
                        ]);
                    }
                    $tag_ids[] = $tag->id;
                }
            }

            $product = Product::create($data);
            // the sync function is used only with belongToMany relationships and here I assigned the tags array to the tags model after creating it.
            $product->tags()->sync($tag_ids);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        }
        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $options = $product->options;
        $options = json_decode($options);
        return view('dashboard.products.show', compact('product', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($id);

        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            //Comment:- The pluck() method in Laravel and PHP is used to extract a specific column's values from a collection of arrays or objects.
            $tags = implode(',', $product->tags()->pluck('name')->toArray());
            $user = auth()->user();
            $stores = $user->stores;

            return view('dashboard.products.edit', compact('product', 'tags', 'stores'));
        }
        return redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'              => ['required', 'min:3', 'max:100'],
            'description'       => ['required', 'min:100', 'max:255'],
            'qty'               => ['required'],
            'price'             => ['required', 'numeric'],
            'image'             => ['mimes:jpg,jpeg,png,webp'],
            'category_id'       => ['required', Rule::exists('categories', 'id')],
            'store_id'          =>  'required|exists:stores,id',
        ]);

        if (!$request->hasFile('image')) {
            return 'You have to pick-up a photo for the product!';
        }
        $old_image = $product->image;
        Storage::disk('public')->delete($old_image);

        $file = $request->file('image');
        $path = $file->store('uploads/products', 'public');
        $options = json_encode($request->post('options'));

        $product->update([
            $request->except('tags'),
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'qty' => $request->post('qty'),
            'price' => $request->post('price'),
            'category_id' => $request->post('category_id'),
            'store_id' => $request->post('store_id'),
            'status' => $request->post('status'),
            'image' => $path,
            'options' => $options,
        ]);

        $tags = json_decode($request->post('tags'));
        $tag_ids = [];
        $allTags = Tag::all();
        foreach ($tags as $tag_name) {
            $slug = Str::slug($tag_name->value);
            $tag = $allTags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $tag_name->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        // the sync function is used only with belongToMany relationships and here I assigned the tags array to the tags model after creating it.
        $product->tags()->sync($tag_ids);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product Deleted Successfully!');
        }
        return redirect()->route('products.index')->with('error', 'You are not authorized to delete products!');
    }

    public function createSlider()
    {
        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            return view('dashboard.products.slider');
        }
        return redirect()->route('login');
    }

    public function storeSlider(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:5',
            'image' => 'required|mimes:png,jpg',
            'price' => 'required',
        ]);

        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            if ($request->file('image')) {
                $file = $request->file('image');
                $path = $file->store('hero/slider', 'public');
            }

            HeroSlider::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'image' => $path,
                'price' => $validatedData['price'],
            ]);
            return back()->with('success', 'Slider Created Successfully!');
        }
        return back()->with('error', 'You are not authorized to create sliders!');
    }
}
