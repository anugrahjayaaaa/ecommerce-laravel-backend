<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\StoreProductRequest;
use App\Http\Requests\V1\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'products retrieved successfully',
            'data' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                'products',
                $data['slug'] . '.' . $request->file('image')->extension(),
                'public'
            );
        }

        $product = Product::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Products created successfully',
            'data' => $product->load('category'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'data' => $product->load('category'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // delete current image if exist
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }


            $data['image'] = $request->file('image')->storeAs(
                'products',
                $data['slug'] . '.' . $request->file('image')->extension(),
                'public'
            );
        }

        $product->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Products updated successfully',
            'data' => $product->load('category'),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // delete current image if exist
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }
}
