<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with(['images' => function($query) {
            $query->select('id', 'product_id', 'path');
        }])->get();

        return response()->json($product, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(ProductRequest $request)
    {

        $product = Product::create([
            'sku' => SKU_GENERATOR($request->name) ?? 123,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'status' => true,
        ]);


        $imagePaths = upload_product_images($product, $request->file('images'));

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product,
            'images' => $imagePaths,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request)
    {

        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }else{
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
            ]);
            $imagePaths = [];
            if ($request->hasFile('images')) {
                $imagePaths = upload_product_images($product, $request->file('images'));
            }

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
                'images' => $imagePaths,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }

    /**
     * Update status in the product.
     */
    public function Status(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        $product->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Product status updated successfully',
            'product' => $product,
        ], 200);
    }

}
