<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']) ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/get/products/import', [ProductController::class, 'importView'])->name('product.importView');
    Route::post('/post/products/import', [ProductController::class, 'import'])->name('product.import');  
    Route::get('/get/products/dashboard', [ProductController::class, 'index'])->name('product.index'); 
    Route::get('/batches/products/view/{id}', [ProductController::class, 'view_batch'])->name('product.view_batch'); 
    Route::get('/products/pdf/download/{id}', [ProductController::class, 'generatePDF'])->name('product.generatePDF'); 
    Route::get('/create/fpdf/download/{id}', [ProductController::class, 'createPDF'])->name('product.createPDF'); 
   


});
require __DIR__.'/auth.php';
