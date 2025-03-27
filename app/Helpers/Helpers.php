<?php

use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;

if (!function_exists('upload_product_images')) {
    function upload_product_images($product, $images)
    {
        $imagePaths = [];

        foreach ($product->images as $image) {

            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
        }

        if ($images && is_array($images)) {
            foreach ($images as $image) {

                $filename = $image->getClientOriginalName();
                $path = $image->storeAs('products', uniqid() . '_' . $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path
                ]);

                $imagePaths[] = $path;
            }
        }

        return $imagePaths;
    }
}


if (!function_exists('SKU_GENERATOR')) {
    function SKU_GENERATOR($product)
    {
        $randomNumber = rand(1000, 9999);
        $sku = strtoupper('SKU-' . uniqid('') . '-' . $randomNumber);
        return $sku;
    }
}

