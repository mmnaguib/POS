<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\DachboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\OrderController as OrderControllerAdmin;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=> ['localizationRedirect', 'localeSessionRedirect', 'localeViewPath']], function(){
    Route::group(['prefix' => 'dashboard', 'middleware'=> 'auth'], function(){
        Route::get('welcome',  [DachboardController::class,'index'])->name('dashboard.index');

        // Categories Routes
        Route::get('categories',  [CategoryController::class,'index'])->name('categories.index');
        Route::get('categories/create',  [CategoryController::class,'create'])->name('categories.create');
        Route::post('categories/store',  [CategoryController::class,'store'])->name('categories.store');
        Route::get('categories/edit/{id}',  [CategoryController::class,'edit'])->name('categories.edit');
        Route::post('categories/update/{id}',  [CategoryController::class,'update'])->name('categories.update');
        Route::post('categories/destroy/{id}',  [CategoryController::class,'destroy'])->name('categories.destroy');

        // Products Routes
        Route::get('products',  [ProductController::class,'index'])->name('products.index');
        Route::get('products/create',  [ProductController::class,'create'])->name('products.create');
        Route::post('products/store',  [ProductController::class,'store'])->name('products.store');
        Route::get('products/edit/{id}',  [ProductController::class,'edit'])->name('products.edit');
        Route::post('products/update/{id}',  [ProductController::class,'update'])->name('products.update');
        Route::post('products/destroy/{id}',  [ProductController::class,'destroy'])->name('products.destroy');

        // Clients Routes
        Route::get('clients',  [ClientController::class,'index'])->name('clients.index');
        Route::get('clients/create',  [ClientController::class,'create'])->name('clients.create');
        Route::post('clients/store',  [ClientController::class,'store'])->name('clients.store');
        Route::get('clients/edit/{id}',  [ClientController::class,'edit'])->name('clients.edit');
        Route::post('clients/update/{id}',  [ClientController::class,'update'])->name('clients.update');
        Route::post('clients/destroy/{id}',  [ClientController::class,'destroy'])->name('clients.destroy');

        // Client Orders Routes
        Route::resource('/client.orders', OrderController::class)->except('show');

        // Users Routes
        Route::get('users',  [UserController::class,'index'])->name('users.index');
        Route::get('users/create',  [UserController::class,'create'])->name('users.create');
        Route::post('users/store',  [UserController::class,'store'])->name('users.store');
        Route::get('users/edit/{id}',  [UserController::class,'edit'])->name('users.edit');
        Route::post('users/update/{id}',  [UserController::class,'update'])->name('users.update');
        Route::post('users/destroy/{id}',  [UserController::class,'destroy'])->name('users.destroy');

        // Orders Routes
        Route::resource('/orders', OrderControllerAdmin::class);
        Route::get('/orders/{order}/products',  [OrderControllerAdmin::class,'products'])->name('orders.products');
    });
});


Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
