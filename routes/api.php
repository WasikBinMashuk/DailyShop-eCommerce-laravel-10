<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/customer/order', [OrderController::class, 'orders']);

    // Cart route
    Route::get('/view-cart', [CartController::class, 'viewCart']);
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
});

Route::get('/shop/products', [OrderController::class, 'products']);

// Cart API Routes

Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->middleware('api-session');
Route::get('/empty-cart', [CartController::class, 'emptyCart'])->middleware('api-session');



Route::get('/messages', function () {
    return response()->json([
        'message' => 'Hello from the other side...',
        'status_code' => 200,
    ]);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
