<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get("/login",[LoginController::class,"index"])->name("login");
Route::post("/login",[LoginController::class,"adminLogin"])->name("admin.login");
Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');

Route::post("save-new-business",[BusinessController::class,"store"])->name("business.save");
Route::get("business-list",[BusinessController::class,"show"])->name("business.list");