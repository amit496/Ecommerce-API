<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'is_active',
        'sku'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
