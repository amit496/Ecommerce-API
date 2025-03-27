<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::controller(ProductController::class)->prefix('product')->group(function () {

    Route::get('/index', 'Index');
    Route::post('/store', 'Store');
    Route::delete('/destroy', 'Destroy');
    Route::post('/update', 'Update');
    Route::get('/status', 'Status');


});






// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
