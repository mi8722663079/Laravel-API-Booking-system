<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::delete('user.delete/{id}',[AuthController::class,"deleteUser"])->middleware(["auth:sanctum","isAdmin"]);
Route::middleware("guest:sanctum")->group(function(){
    Route::post('register',[AuthController::class,"register"]);
    Route::post('verify-otp',[AuthController::class,"verifyOtp"]);
    Route::post('login',[AuthController::class,"login"]);
    
});

Route::delete('logout',[AuthController::class,"logout"])->middleware("auth:sanctum");

Route::middleware(["auth:sanctum","isAdmin"])->group(function(){
    // Category Routes
    Route::get("category.all", [CategoryController::class, "index"]);
    Route::get("category.show/{id}", [CategoryController::class, "show"]);
    Route::post("category.create", [CategoryController::class, "store"]);
    Route::put("category.update/{id}", [CategoryController::class, "update"]);
    Route::delete("category.delete/{id}", [CategoryController::class, "destroy"]);
});

// Event Routes
Route::get("event.all", [EventController::class, "index"])->middleware("auth:sanctum");

Route::get("event.show/{id}", [EventController::class, "show"])->middleware("auth:sanctum");

Route::post("event.create", [EventController::class, "store"])->middleware(["auth:sanctum","isAdmin"]);

Route::put("event.update/{id}", [EventController::class, "update"])->middleware(["auth:sanctum","isAdmin"]);

Route::delete("event.delete/{id}", [EventController::class, "destroy"])->middleware(["auth:sanctum","isAdmin"]);

// booking routes
Route::middleware(["auth:sanctum"])->group(function(){

    Route::post("booking.book/", [BookingController::class, "book"]);
    Route::get("booking.user", [BookingController::class, "userBookings"]);
    Route::put("booking.update", [BookingController::class, "update"]);
    Route::delete("booking.cancel/{id}", [BookingController::class, "destroy"]);
    
});

Route::get("booking.all", [BookingController::class, "allBookings"])->middleware(["auth:sanctum","isAdmin"]);
Route::get("booking.confirmed", [BookingController::class, "allConfirmedBookings"])->middleware(["auth:sanctum","isAdmin"]);