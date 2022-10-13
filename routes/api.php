<?php

use Illuminate\Support\Facades\Route;
/** Models */
use App\Http\Controllers\{AuthController, FavoritesController};

/** Auth Routes */
Route::prefix("auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
    Route::get("/active_user/{id}", [AuthController::class, "activeUser"]);
});

Route::prefix("favorites")->group(function(){
    Route::get("/get-favorites", [FavoritesController::class, "getFavorites"]);
    Route::post("/add-favorites", [FavoritesController::class, "addFavorites"]);
});
