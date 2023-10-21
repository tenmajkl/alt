<?php

use App\Controllers\Auth\Login;
use App\Controllers\Admin\Posts;
use App\Controllers\Welcome;
use App\Middlewares\Auth;
use Lemon\Route;

Route::get('/', [Welcome::class, 'handle']);

Route::collection(function() {
    Route::controller('login', Login::class);
})->middleware([Auth::class, 'onlyGuest']);

Route::collection(function() {
    Route::controller('posts', Posts::class);
})->middleware([Auth::class, 'onlyAdmin']);
