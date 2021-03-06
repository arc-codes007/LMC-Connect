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

Route::post('/editposts/{random_id}', [App\Http\Controllers\PostsController::class, 'storeedit'])->name('storeeditpost');
//Profile Routes

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'view_user'])->name('profile.view_user');

Route::post('/profile/save', [App\Http\Controllers\ProfileController::class, 'save'])->name('profile.save');

Route::get('/posts/view/{post_id}', [App\Http\Controllers\PostsController::class, 'viewpost'])->name('post.show');

Route::get('/posts/resumne/download/{file_name}', [App\Http\Controllers\ResumeController::class, 'download'])->name('downloadresume');

Route::get('/account/edit/{username}', [App\Http\Controllers\Auth\UpdateUserController::class, 'show_update_account_form'])->name('show_update_account_form');

Route::post('/account/update', [App\Http\Controllers\Auth\UpdateUserController::class, 'update_account'])->name('update_account');

Route::post('/account/delete', [App\Http\Controllers\Auth\UpdateUserController::class, 'delete_account'])->name('delete_account');

Route::get('/user/saved_post', [App\Http\Controllers\PostsController::class, 'user_saved_posts'])->name('user_saved_posts');

// Route::post('/account/delete', function () {
//     dd("sadawsd");
// })->name('delete_account');

Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_dashboard');

Route::get('/admin-dashboard/all_user_list', [App\Http\Controllers\AdminController::class, 'open_all_user_list'])->name('admin_panel.open_all_user_list');

Route::get('/admin-dashboard/open_deleted_user_list', [App\Http\Controllers\AdminController::class, 'open_deleted_user_list'])->name('admin_panel.open_deleted_user_list');

Route::get('/admin-dashboard/restore_user/{username}', [App\Http\Controllers\AdminController::class, 'restore_user'])->name('admin_panel.restore_user');

Route::get('/admin-dashboard/make_announcement_form', [App\Http\Controllers\AdminController::class, 'make_announcement_form'])->name('admin_panel.make_announcement_form');

Route::post('/admin-dashboard/save_announcement', [App\Http\Controllers\AdminController::class, 'save_announcement'])->name('admin_panel.save_announcement');

Route::get('/home/view_announcement/{random_id}', [App\Http\Controllers\HomeController::class, 'view_announcement'])->name('home.view_announcement');





