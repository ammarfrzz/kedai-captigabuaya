<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Midtrans Webhook Notification Handler (Bebas dari middleware CSRF)
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('api.midtrans.notification');

