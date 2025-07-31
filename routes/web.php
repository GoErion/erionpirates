<?php

declare(strict_types=1);

use App\Http\Controllers\BookmarksController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureVerifiedEmailsForSignInUsers;
use Illuminate\Support\Facades\Route;


Route::view('/about','about')
    ->name('about');

Route::view('/','home/feed')->name('home.feed');
Route::redirect('/for-you', '/following')->name('home.for_you');
Route::view('/following', 'home/following')->name('home.following');
Route::view('/trending', 'home/trending-questions')->name('home.trending');
Route::view('/users', 'home/users')->name('home.users');

Route::prefix('/@{username}')->group(function () {
    Route::get('/', [UserController::class, 'show'])
        ->name('profile.show')
        ->middleware(EnsureVerifiedEmailsForSignInUsers::class);

//    Route::get('questions/{question}', [QuestionController::class, 'show'])
//        ->name('questions.show')
//        ->middleware(EnsureVerifiedEmailsForSignInUsers::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('bookmarks',[BookmarksController::class,'index'])
        ->name('bookmarks.index');

    Route::get('notifications',[NotificationController::class,'index'])
        ->name('notifications.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])
        ->name('profile.destroy');
});
require __DIR__.'/auth.php';
