<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopperController;
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

Route::get('/', function () {
    return view('welcome');
});
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

// users CRUD
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/update', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');

// change password
Route::get('/changePassword',[UserController::class, 'changePassword'])->name('changePassword');
Route::post('/updatePassword',[UserController::class, 'updatePassword'])->name('updatePassword');


// Categories
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/update', [CategoryController::class, 'update'])->name('category.update');
// Route::post('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'createCat'])->name('category.create');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('subCategory/create', [CategoryController::class, 'createSubCat'])->name('subcategory.create');
Route::post('subCategory/store', [CategoryController::class, 'storeSubCat'])->name('subcategory.store');