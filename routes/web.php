<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainContoller;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard',[MainContoller::class, 'index'])->middleware(['auth' , 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/delete/{id}', [MainContoller::class, 'delete'])->name('delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
