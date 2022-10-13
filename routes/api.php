<?php

use Illuminate\Support\Facades\Route;
/** Models */
use App\Http\Controllers\{AuthController};

/** Auth Routes */
Route::prefix("auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
    Route::get("/active_user/{id}", [AuthController::class, "activeUser"]);
});
