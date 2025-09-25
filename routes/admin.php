<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\AdminMiddleware::class])->prefix("admin")->name("admin.")->group(function () {
});

    Route::get("/dashboard", [AdminController::class, "dashboard"])->name("dashboard");


Route::resource("categories", Admin\CategoryController::class);


Route::resource("products", Admin\ProductController::class);


Route::resource("orders", Admin\OrderController::class);

