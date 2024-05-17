<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Models\Color;
use App\Models\Size;



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
    $colors = Color::get();
    $sizes = Size::get();
    $page = 'product';
    $pageTitle = 'Add Product';
    return view('pages.product',compact('page', 'pageTitle', 'colors', 'sizes'));
});

Route::get('/product', [ProductController::class, 'create'])->name('product.create');
Route::get('/product-lists', [ProductController::class, 'index'])->name('product.index');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{encriptedId}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::put('/update-product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/view-product/{id}', [ProductController::class, 'show'])->name('product.show');



Route::get('/color', [ColorController::class, 'create'])->name('color.create');
Route::get('/color-lists', [ColorController::class, 'index'])->name('color.index');
Route::post('/color', [ColorController::class, 'store'])->name('color.store');
Route::get('/edit-color/{encriptedId}', [ColorController::class, 'edit'])->name('color.edit');
Route::delete('/delete-color/{id}', [ColorController::class, 'destroy'])->name('color.destroy');
Route::put('/update-color/{id}', [ColorController::class, 'update'])->name('color.update');

Route::get('/size', [SizeController::class, 'create'])->name('size.create');
Route::get('/size-lists', [SizeController::class, 'index'])->name('size.index');
Route::post('/size', [SizeController::class, 'store'])->name('size.store');
Route::get('/edit-size/{encriptedId}', [SizeController::class, 'edit'])->name('size.edit');
Route::delete('/delete-size/{id}', [SizeController::class, 'destroy'])->name('size.destroy');
Route::put('/update-size/{id}', [SizeController::class, 'update'])->name('size.update');





