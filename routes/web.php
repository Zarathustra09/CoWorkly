<?php

use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/checkout/{booking}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{booking}/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

// Booking routes
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/workspace/{workspace}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');



// In routes/web.php
Route::get('/my-workspaces', [App\Http\Controllers\WorkSpaceController::class, 'index'])->name('workspace.index');


Route::get('group-chats/{groupChat}', [GroupChatController::class, 'show'])
    ->name('group-chats.show');

// Store a new message in the group chat
Route::post('group-chats/{groupChat}/messages', [GroupChatController::class, 'store'])
    ->name('group-chats.messages.store');

// Add a user to the group chat (booking creator only)
Route::post('group-chats/{groupChat}/users', [GroupChatController::class, 'add'])
    ->name('group-chats.users.add');


Route::post('group-chats/{groupChat}/users/remove', [GroupChatController::class, 'remove'])->name('group-chats.users.remove');

// Delete a message from the group chat
Route::delete('group-chat-messages/{message}', [GroupChatController::class, 'delete'])
    ->name('group-chats.messages.delete');

Route::get('/chats', [GroupChatController::class, 'index'])->name('group-chats.index');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::put('/profile/upload-image', [App\Http\Controllers\ProfileController::class, 'uploadImage'])->name('profile.upload-image')->middleware('auth');
