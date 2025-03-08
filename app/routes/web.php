<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\WelcomeController::class)->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth', 'withTrashed' => true], static function () {
    Route::get('/user', UserController::class)->name('user.index');

    Route::resource('article', \App\Http\Controllers\Admin\ArticleController::class)->withTrashed();
    Route::resource('comment', \App\Http\Controllers\Admin\CommentController::class)->withTrashed();
    Route::resource('like', \App\Http\Controllers\Admin\LikeController::class)->withTrashed();
});
