<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class ProductsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:sanctum')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function uploadImage (Request $request) {
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
        return Product::filters($request->query())
        // Here you can define what relations u want to send in the api response with its details
        ->with('category:id,name', 'store:id,name', 'tags:id,name')
        ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|min:3|max:255',
            'category_id'   => 'required|exists:categories,id',
            // 'store_id'      => auth()->user()->store_id,
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|bt:price',
            'status'        =>  'in:active,inactive,draft',
            'qty'           => 'required|numeric|gte:5',
            'image'         =>  'required|image|mimes:jpg, jpeg, png, bmp, gif, svg, or webp',
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $product = Product::create($data);

        return [$product, 'status' => 200];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        // this is another way to get data with its relations.
        return $product->load('category:id,name', 'store:id,name', 'tags:id,name');

        // and this if you want to use the json resource to fetch the data with custom shape.
        // return new ProductResource($product);

        // return ['Single_Product', $product, 'Status', 200];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // this validation rule [sometimes] is used when we wanted to make a field is required but when it was empty but if it wasn't sent at all it won't be required.
            'name'          => 'sometimes|required|string|min:3|max:255',
            'category_id'   => 'sometimes|required|exists:categories,id',
            // 'store_id'      => auth()->user()->store_id,
            'price'         => 'sometimes|required|int',
            'compare_price' => 'nullable|int|bt:price',
            'status'        =>  'in:active,inactive,draft',
            'qty'           => 'sometimes|required|numeric|gte:5',
            'image'         =>  'sometimes|required|image|mimes:jpg, jpeg, png, bmp, gif, svg, or webp',
        ]);

        $product = Product::findOrFail($id);

        $old_image = $product->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $product->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return [
            $product,
            'Message'   => 'Product updated successfully!',
            'Status'    =>  200,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::guard('admin')->check()) {
            Product::destroy($id);
            return response()->json([null, 204]);
        } else {
            return abort(404);
        }
    }

}
