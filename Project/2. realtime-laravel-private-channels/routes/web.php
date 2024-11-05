<?php

use App\Http\Controllers\ProfileController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/order/{order}', function (Order $order) {
    return view('order', [
        'order' => $order
    ]);
})->middleware(['auth', 'verified']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/broadcast', function () {
    broadcast(new \App\Events\OrderDispatched(\App\Models\Order::find(1)));
    broadcast(new \App\Events\OrderDelivered(\App\Models\Order::find(1)));

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
