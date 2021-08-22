<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/profile/get_course_year_details', [App\Http\Controllers\ProfileController::class, 'get_course_year_details'])->name('get_course_year_details');

Route::middleware('auth:api')->post('/social_access/create_request', [App\Http\Controllers\SocialAccessController::class, 'create_social_access_request'])->name('social_access.create_request');

Route::middleware('auth:api')->get('/comment/get_comments', [App\Http\Controllers\CommentsController::class, 'get_comments'])->name('get_comments');

Route::middleware('auth:api')->post('/social_access/accept_decline_request', [App\Http\Controllers\SocialAccessController::class, 'accept_decline_social_access_request'])->name('social_access.accept_decline_request');

Route::middleware('auth:api')->get('/home/get_posts', [App\Http\Controllers\HomeController::class, 'get_posts'])->name('home.get_posts');

Route::middleware('auth:api')->post('/posts/comments', [App\Http\Controllers\PostsController::class, 'storecomment'])->name('storecomment');

// Route::middleware('auth:api')->post('/posts/comments', function (Request $request) {
//     dd($request->all());
// })->name('storecomment');
