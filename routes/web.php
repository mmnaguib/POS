<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\DachboardController;
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
    return view('welcome');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=> ['localizationRedirect', 'localeSessionRedirect', 'localeViewPath']], function(){
    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('welcome',  [DachboardController::class,'index'])->name('dashboard.index');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
