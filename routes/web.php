<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestimoniController;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('login', [AuthController::class, 'login_member']);
// Route::post('logout', [AuthController::class, 'logout_member']);


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);


Route::get('/kategori', [CategoryController::class, 'list']);
Route::get('/subkategori', [SubcategoryController::class, 'list']);
Route::get('/slider', [SliderController::class, 'list']);
Route::get('/barang', [ProductController::class, 'list']);
Route::get('/testimoni', [TestimoniController::class, 'list']);
Route::get('/review', [ReviewController::class, 'list']);


Route::get('/dashboard', [DashboardController::class, 'index']);
