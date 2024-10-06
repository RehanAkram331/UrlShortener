<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short-urls.index');
    Route::post('/short-urls/store', [ShortUrlController::class, 'store'])->name('short-urls.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/{shortUrl}', [ShortUrlController::class, 'redirectToOriginal'])->name('redirect');

require __DIR__.'/auth.php';
