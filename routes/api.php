<?php

use Illuminate\Support\Facades\Route;

Route::prefix('login')->group(function () {
    Route::post('', [\App\Http\Controllers\Api\LoginController::class, 'login']);
});
Route::middleware('auth:api')->prefix('user')->group(function () {
    \Esatic\ActiveUser\Service\Routes::users();
});

Route::prefix(env('ADMIN_PATH', 'administrator'))->group(function () {
    Route::post('login', \App\Http\Controllers\Api\Admin\LoginController::class);
    Route::middleware('auth:admin')->prefix('users')->group(function () {
        \Esatic\ActiveUser\Service\Routes::admin();
    });
});
