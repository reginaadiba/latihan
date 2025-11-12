<?php

use App\Models\Phone;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Jobs\ProcessWelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

//index
Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function() {
    return auth()->user()->name;
})->middleware('verified');

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



Route::middleware(['auth', 'verified'])->group(function(){
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
    Route::get('/users', [UserController::class, 'index']);


    Route::get('/phones', function() {
        $phones = Phone::with('user')->get();
        return $phones;
    })->middleware('tokenvalid');

    Route::get('/images', [ImageController::class, 'index']);
    Route::get('/articles', [ArticleController::class, 'index']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'createUser']);
});

Route::middleware('auth')->group(function() {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});



// Upload Image
    Route::get('/upload', function(){
        // local akan disimpan di storage/app/private nama file example.txt -> isinya 'contents'
        // public akan disimpan di storage/app/public
        // Storage::put('example.txt', 'contents'); -> akan disimpan secara default di private (sesuai setting default filesystem atau env/filesystem_disk)
        Storage::disk('public')->put('public1.txt', 'public nih');
    });

    //cara menampilkan file yg sudah di upload
    Route::get('/thefile', function() {
        // Cara 1:
        // return asset('storage/example.txt');

        // Cara 2:
        return Storage::url('public1.txt');
        //output => 'http://localhost/storage/example.txt', supaya jadi latihan.test => edit file env (APP_URL => latihan.test)
    });

    //upload dengan form
    Route::get('/upload-image', function() {
        return view('upload-image');
    });

    Route::post('/upload-image', function(Request $request) {
        // return $request->file('image'); //test upload
        //images = nama folder
        $file = $request->file('image');
        $ext = $file->extension();
        $path = Storage::putFile('images', $file); //->nama file akan random
        // $path = Storage::putFileAs('images', $file, 'delima.' . $ext);

        return $path;
        //akan error path => stop laragon -> klik kanan pilih php -> php.ini -> ganti upload_tmp_dir = C:/laragon/tmp -> save + start laragon
        // upload ulang -> akan dapat respon letak file -> langsung buka dengan laravel.test/storage/respon
    });


// Mail & Queue
Route::get('/send-welcome-mail', function() {
    // $user = [
    //     'username' => 'haechandeul',
    //     'email' => 'haechan@email.com', 
    //     'password' => '123456', 
    //     'image' => 'image1.jpg'
    // ];
    // Mail::to($user['email'])->send(new WelcomeMail($user));
    $users = [
        ['email' => 'haechan@email.com', 'password' => '123456'],
        ['email' => 'mark@email.com', 'password' => '123456'],
        ['email' => 'jungwoo@email.com', 'password' => '123456'],
        ['email' => 'winwin@email.com', 'password' => '123456'],
        ['email' => 'jaehyun@email.com', 'password' => '123456'],
        ['email' => 'doyoung@email.com', 'password' => '123456'],
        ['email' => 'yuta@email.com', 'password' => '123456'],
        ['email' => 'taeyong@email.com', 'password' => '123456'],
        ['email' => 'johnny@email.com', 'password' => '123456'],
        ['email' => 'giselle@email.com', 'password' => '123456'],
    ];

    foreach ($users as $user) {
        // queue
        ProcessWelcomeMail::dispatch($user)->onQueue('send-email');
    }
});