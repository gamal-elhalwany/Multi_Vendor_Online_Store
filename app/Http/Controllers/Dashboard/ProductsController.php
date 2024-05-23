<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\HeroSlider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Store;

class ProductsController extends Controller
{
    function __construct()
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

        // I used the global scope instead of the above code and repeat it every time.
        $products = Product::filter($request->all())->latest()->orderby('name')->paginate();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Hello From Creation Page of Products that we haven't Create it yet ♥.";
        // return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'min:3', 'max:100'],
            'descirption'   => ['required', 'min:100', 'max:255'],
            'price'         => ['required', 'numeric', 'double'],
            'category'   => ['required', 'nullable', Rule::exists('categories', 'id')],
            'image'         => ['required', 'nullable', 'mimes:jpg,jpeg,png'],
            'compare_price' => ['numeric'],
            'store'      =>  'required|string|exists:stores,name',
            'tags'      =>   'string|min:3|max:15',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        //Comment:- the pluck() method is used to retrieve a list of specific values from a collection of records in the database. This method allows you to specify the field you want to extract values from and is typically used to retrieve a single value or a small set of values from a result set.
        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => ['required', 'min:3', 'max:100'],
            'descirption'   => ['required', 'min:100', 'max:255'],
            'price'         => ['required', 'numeric', 'double'],
            'category'   => ['required', Rule::exists('categories', 'id')],
            'image'         => ['required', 'nullable', 'mimes:jpg,jpeg,png'],
            'compare_price' => ['numeric', 'nullable'],
            'store'      =>  'required|string|exists:stores,name',
        ]);

        $product->update($request->except('tags'));

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
    public function destroy(string $id)
    {
        //
    }

    public function createSlider()
    {
        return view('dashboard.products.slider');
    }

    public function storeSlider(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:5',
            'image' => 'required|mimes:png,jpg',
            'price' => 'required',
        ]);

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
}