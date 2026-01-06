<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) return to_route('home');
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'middleware' => ['auth']
], function() {
    Route::get('master-data/ajax/user', [AjaxController::class, 'user'])->name('ajax.user');
    Route::resource('user', UserController::class)->names('user');
    Route::resource('role', RoleController::class)->names('role')->except('show');

    Route::get('notifications/get', [NotificationsController::class, 'getNotificationsData'])->name('notifications.get');
});