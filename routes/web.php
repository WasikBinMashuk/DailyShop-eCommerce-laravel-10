<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\RoleController;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

//Email Verification Routes
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Localization Route
Route::get('lang/change', [LangController::class, 'lang_change'])->name('lang.change');

// auth group route for users, categories, subcategories and products
Route::group(['middleware'=>['auth','verified']],function(){
    
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    // users CRUD routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:user edit');
    Route::put('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/delete', [UserController::class, 'delete'])->name('users.delete')->middleware('role:Super Admin');

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

    // Sliders crud route in admin panel
    Route::resource('sliders', SliderController::class);

    // orders routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{id}/details', [OrderController::class, 'details'])->name('orders.details');

    // Roles routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('role:Super Admin');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store')->middleware('role:Super Admin');
    Route::post('/roles/permission/store', [RoleController::class, 'permissionStore'])->name('permission.store')->middleware('role:Super Admin');
    Route::post('/roles/permissions/store', [RoleController::class, 'rolePermissionStore'])->name('roles.permission.store')->middleware('role:Super Admin');
});


// frontend routes==============================================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [HomeController::class, 'productShow'])->name('product.show');

// Cart routes
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::post('/add-to-cart-from-product/{id}', [CartController::class, 'addToCartFromProduct'])->name('add_to_cart_from_product');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::patch('/update-cart', [CartController::class, 'update'])->name('update_cart');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');

// Customer login registration routes with middleware
Route::post('customer/login', [CustomerAuthController::class, 'customerLogin'])->name('customer.login');
Route::post('customer/register', [CustomerAuthController::class, 'customerRegister'])->name('customer.register');

// customer dashboard routes with customer middleware
Route::group(['middleware'=>'customer'],function(){
    Route::get('customer/dashboard', [CustomerAuthController::class, 'index'])->name('customer.dashboard');
    Route::put('customer/update', [CustomerAuthController::class, 'profileUpdate'])->name('customer.update');
    Route::post('customer/update/password', [CustomerAuthController::class, 'updatePassword'])->name('customer.change.password');
    Route::put('customer/update/address', [CustomerAuthController::class, 'addressUpdate'])->name('customer.change.address');

    Route::get('customer/logout', [CustomerAuthController::class, 'customerLogout'])->name('customer.logout');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
});


Route::get('send/mail', function(){
    $userMail = 'iqbal@gmail.com';

    // dispatch(new SendEmailJob($userMail));
    SendEmailJob::dispatch($userMail);

    dd('Send mail successfully');
});



// Route::get('/cart', function () {
//     return view('frontend.cart');
// });