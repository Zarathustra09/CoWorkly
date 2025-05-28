<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('workspace', App\Http\Controllers\WorkSpaceController::class)
    ->names('workspace');


Route::resource('workspace-categories', App\Http\Controllers\WorkSpaceController::class)
    ->names('workspace-categories');


