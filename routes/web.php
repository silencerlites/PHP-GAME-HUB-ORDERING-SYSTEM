<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.submit');
    Route::get('/register',[AuthController::class,'showRegister'])->name('register');
    Route::post('/register',[AuthController::class,'register'])->name('register.submit');
});

Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth','active','role:customer'])->prefix('customer')->name('customer.')->group(function(){
    Route::get('/games',[CatalogController::class,'index'])->name('catalog');
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart/{game}',[CartController::class,'add'])->name('cart.add');
    Route::put('/cart/{game}',[CartController::class,'update'])->name('cart.update');
    Route::delete('/cart/{game}',[CartController::class,'remove'])->name('cart.remove');
    Route::delete('/cart',[CartController::class,'clear'])->name('cart.clear');
    Route::post('/checkout',[CartController::class,'checkout'])->name('checkout');
    Route::get('/orders',[CustomerOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}',[CustomerOrderController::class,'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel',[CustomerOrderController::class,'cancel'])->name('orders.cancel');
});

Route::middleware(['auth','active','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
    Route::resource('games',AdminGameController::class)->except('show');
    Route::patch('/games/{game}/toggle',[AdminGameController::class,'toggle'])->name('games.toggle');
    Route::get('/users',[AdminUserController::class,'index'])->name('users.index');
    Route::post('/users/staff',[AdminUserController::class,'storeStaff'])->name('users.staff.store');
    Route::patch('/users/{user}/toggle',[AdminUserController::class,'toggle'])->name('users.toggle');
    Route::get('/orders',[AdminOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}',[AdminOrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status',[AdminOrderController::class,'updateStatus'])->name('orders.status');
});

Route::middleware(['auth','active','role:staff'])->prefix('staff')->name('staff.')->group(function(){
    Route::get('/dashboard',[StaffDashboardController::class,'index'])->name('dashboard');
    Route::get('/orders',[StaffOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}',[StaffOrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status',[StaffOrderController::class,'updateStatus'])->name('orders.status');
});
