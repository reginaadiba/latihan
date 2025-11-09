<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

//index
Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function(){
    return view('blog', ['data' => 'test 123']);
})->name('blog');

// Route::view('/blog', 'blog');
// Route::view('/blog', 'blog', ['data' => 'test passing']);
// route view tidak bisa passing data dari database
// Route::get('/blog', function(){
//     //bisa menggunakan data dari database
//     $profile = 'test';
//     return view('blog', ['data' => $profile]);
// });

//route parameter
// Route::get('/blog/1', function() {
//     return 'Ini adalah blog 1';
// });

// Route::get('/blog/{id}', function($id) {
//     // return 'Ini adalah blog ' . $id;
//     return redirect()->route('blog');
// });

//route blog controller
Route::get('/hitung', [BlogController::class, 'hitung']);
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/add', [BlogController::class, 'add']);
Route::post('/blog/create', [BlogController::class, 'create']);
Route::get('/blog/{id}/detail', [BlogController::class, 'show'])->name('blog-detail');
Route::get('/blog/{id}/edit', [BlogController::class, 'edit']);
Route::patch('/blog/{id}/update', [BlogController::class, 'update']);
Route::get('/blog/{id}/delete', [BlogController::class, 'delete']);
Route::get('/blog/{id}/restore', [BlogController::class, 'restore']);

Route::post('/comment/{blog_id}', [CommentController::class, 'store']);

//route user controller
Route::get('/users', [UserController::class, 'index']);