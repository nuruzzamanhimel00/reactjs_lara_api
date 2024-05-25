<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\AuthenticationAdminController;
use App\Http\Controllers\Api\Admin\CategoryType\CategoryTypeController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('category-type', CategoryTypeController::class);
});
Route::post('/login',[AuthenticationAdminController::class,'login']);

