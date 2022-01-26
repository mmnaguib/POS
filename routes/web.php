<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\DachboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
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
    return view('auth.login');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=> ['localizationRedirect', 'localeSessionRedirect', 'localeViewPath']], function(){
    Route::group(['prefix' => 'dashboard', 'middleware'=> 'auth'], function(){
        Route::get('welcome',  [DachboardController::class,'index'])->name('dashboard.index');
        // Users Routes
        Route::get('users',  [UserController::class,'index'])->name('users.index');
        Route::get('users/create',  [UserController::class,'create'])->name('users.create');
        Route::post('users/store',  [UserController::class,'store'])->name('users.store');
        Route::get('users/edit/{id}',  [UserController::class,'edit'])->name('users.edit');
        Route::post('users/update/{id}',  [UserController::class,'update'])->name('users.update');
        Route::post('users/destroy/{id}',  [UserController::class,'destroy'])->name('users.destroy');
        // Categories Routes
        Route::get('categories',  [CategoryController::class,'index'])->name('categories.index');
        Route::get('categories/create',  [CategoryController::class,'create'])->name('categories.create');
        Route::post('categories/store',  [CategoryController::class,'store'])->name('categories.store');
        Route::get('categories/edit/{id}',  [CategoryController::class,'edit'])->name('categories.edit');
        Route::post('categories/update/{id}',  [CategoryController::class,'update'])->name('categories.update');
        Route::post('categories/destroy/{id}',  [CategoryController::class,'destroy'])->name('categories.destroy');
    });
});


Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
