<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return view('welcome');
    }
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/posts/create', [App\Http\Controllers\PostsController::class, 'create'])->name('createpost');

Route::get('/posts/edit/{random_id}', [App\Http\Controllers\PostsController::class, 'edit'])->name('editpost');

Route::post('/posts', [App\Http\Controllers\PostsController::class, 'store'])->name('storepost');

Route::post('/posts/comments', [App\Http\Controllers\PostsController::class, 'storecomment'])->name('storecomment');

Route::post('/editposts/{random_id}', [App\Http\Controllers\PostsController::class, 'storeedit'])->name('storeeditpost');
//Profile Routes

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'view_user'])->name('profile.view_user');

Route::post('/profile/save', [App\Http\Controllers\ProfileController::class, 'save'])->name('profile.save');

Route::get('/posts/view/{post_id}', [App\Http\Controllers\PostsController::class, 'viewpost'])->name('post.show');

Route::post('/posts/view/', [App\Http\Controllers\ResumeUploadController::class, 'store'])->name('storeresume');
