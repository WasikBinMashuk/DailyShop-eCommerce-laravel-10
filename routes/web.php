<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopperController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/signin', function () {
    return view('signin');
});
// Route::get('/editcategory', function () {
//     return view('categories.editCategory');
// });


Route::get('/dashboard', function () {
    return view('dashboard');
})->Middleware('auth');

// Route::get('/create', function () {
//     return view('create');
// });
Route::get('/dash', function () {
    return view('layouts.dash');
});
// Route::get('/users', function () {
//     return view('users');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// users CRUD routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/update', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');

// change password routes
Route::get('/changePassword',[UserController::class, 'changePassword'])->name('changePassword');
Route::post('/updatePassword',[UserController::class, 'updatePassword'])->name('updatePassword');


// Categories routes

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'createCat'])->name('category.create');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');


// SUB Categories routes
Route::get('/Subcategory', [SubCategoryController::class, 'index'])->name('subcategory.index');
Route::get('/subCategory/create', [SubCategoryController::class, 'createSubCat'])->name('subcategory.create');
Route::get('/subCategory/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
Route::get('/subCategory/delete/{id}', [SubCategoryController::class, 'delete'])->name('subcategory.delete');
Route::post('subCategory/store', [SubCategoryController::class, 'storeSubCat'])->name('subcategory.store');
Route::put('/subCategory/update', [SubCategoryController::class, 'update'])->name('subcategory.update');

// Products routes
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('product.update');
Route::get('/products/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
// Dependant dropdown menu while product
Route::post('/getCategory', [ProductController::class, 'getCategory']);

// Customer crud routes
Route::resource('customers', CustomerController::class);



// frontend template mastering

Route::get('/', [HomeController::class, 'index'])->name('home.index');



// Route::get('/index', function () {
//     return view('frontend.home');
// });
Route::get('/frontdashboard', function () {
    return view('frontend.dashboard');
});
Route::get('/cart', function () {
    return view('frontend.cart');
});
Route::get('/checkout', function () {
    return view('frontend.checkout');
});
Route::get('/shop', function () {
    return view('frontend.shop');
});
// Route::get('/login', function () {
//     return view('frontend.login');
// });
Route::get('/front', function () {
    return view('layouts.front');
});