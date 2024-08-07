<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::get('/', function () {
    return view('home');
});
Route::post('stripe',[StripeController::class, 'stripe'])->name('stripe');
Route::get('success',[StripeController::class, 'success'])->name('success');
Route::post('cancel',[StripeController::class, 'cancel'])->name('cancel');