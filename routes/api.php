<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::controller(ProductController::class)->prefix('product')->group(function () {

    Route::post('/store', 'Store');
});






// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
