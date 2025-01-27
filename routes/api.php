<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\PaymeController; 
use App\Http\Controllers\Api\UserAuthController; 
use App\Http\Controllers\Api\UserCoursController; 
use App\Http\Controllers\Api\UserController; 
use App\Http\Controllers\TkunController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/payme', [PaymeController::class, 'index']);

Route::get('/tkun', [TkunController::class, 'index']);



Route::post("login", [UserAuthController::class, "login"]);
Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("profile", [UserAuthController::class, "profile"]);
    Route::get("logout", [UserAuthController::class, "logout"]);
    
    Route::get("home", [UserController::class, "home"]);
    Route::get("home/show/{id}", [UserController::class, "home_show"]);
    Route::get("paymart", [UserController::class, "paymart"]);

    
    Route::get("courss", [UserCoursController::class, "courss"]);
    
    Route::get("test", [UserCoursController::class, "test"]);
    Route::post("test/check", [UserCoursController::class, "test_check"]);

    
});