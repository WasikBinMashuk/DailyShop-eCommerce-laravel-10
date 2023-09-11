<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\UserController;
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




Auth::routes();

// Route::get('/dashboard', function () {return view('dashboard');})->Middleware('auth'); // TODO:: controller add


// auth group route for users, categories, subcategories and products
Route::group(['middleware'=>'auth'],function(){
    
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

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
    // Dependant dropdown menu while product
    Route::post('/getSubCategory', [SubCategoryController::class, 'getSubCategory']);

    // Products routes
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('/products/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');

    // Customer crud routes in admin panel
    Route::resource('customers', CustomerController::class);
});

// frontend template mastering
Route::get('/', [HomeController::class, 'index'])->name('home.index');


// Customer login registration routes with middleware
Route::post('customer/login', [CustomerAuthController::class, 'customerLogin'])->name('customer.login');
Route::post('customer/register', [CustomerAuthController::class, 'customerRegister'])->name('customer.register');

Route::group(['middleware'=>'customer'],function(){
    Route::get('customer/dashboard', [CustomerAuthController::class, 'index'])->name('customer.dashboard');
    Route::get('customer/logout', [CustomerAuthController::class, 'customerLogout'])->name('customer.logout');
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