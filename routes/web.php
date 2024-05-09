<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

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

Route::group(['prefix' => 'translate'], function () {
    Route::get('/', [TranslationController::class, 'index'])->name('translate.view');
    Route::post('/', [TranslationController::class, 'translate'])->name('translate');
    Route::post('store', [TranslationController::class, 'store'])->name('translate.store');
    Route::get('lesson/{id}', [TranslationController::class, 'show'])->name('translate.show');
    Route::delete('lesson/{id}', [TranslationController::class, 'delete'])->name('translate.delete');
});

Route::get('/', [TranslationController::class, 'home'])->name('home');
