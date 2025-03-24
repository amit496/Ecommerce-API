<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\ProductImage;

if (!function_exists('upload_product_images')) {
    function upload_product_images($product, $images)
    {
        $imagePaths = [];

        foreach ($images as $image) {

            $img = Image::make($image);

            $smallPath = 'products/images/small/' . $image->hashName();
            $mediumPath = 'products/images/medium/' . $image->hashName();
            $largePath = 'products/images/large/' . $image->hashName();

            $small = $img->resize(300, 300);
            $medium = $img->resize(600, 600);
            $large = $img->resize(1200, 1200);

            $small->save(storage_path('app/public/' . $smallPath));
            $medium->save(storage_path('app/public/' . $mediumPath));
            $large->save(storage_path('app/public/' . $largePath));

            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->path = $smallPath;
            $productImage->save();

            $imagePaths[] = [
                'small' => $smallPath,
                'medium' => $mediumPath,
                'large' => $largePath
            ];
        }

        return $imagePaths;
    }
}

if (!function_exists('SKU_GENERATOR')) {
    function SKU_GENERATOR($product)
    {
        $sku = strtoupper(substr($product->name, 0, 3)) . '-' . strtoupper(uniqid('SKU-'));
        return $sku;
    }
}
