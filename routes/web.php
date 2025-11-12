<?php

use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\EnsureTokenIsValid;

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



Route::middleware('auth')->group(function(){
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
        //output => 'http://latihan.test/storage/example.txt' (kalo dibuka akan forbidden krn storage tidak boleh diakses dari luar)
        //solusi jalankan => php artisan storage:link => setelah berhasil akan muncul folder storage di folder public
        //di folder public akan langsung terisi file yg diupload dari disk public (bukan local atau private)
        //kalo sudah di-link-kan (storage:link) maka url output tadi akan bisa diakses

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

// setting env dg mailtrap
// mail_from_address latihan@example.com
// mail_name_from latihan
// lalu jalankan: php artisan make:mail WelcomeMail -> akan muncul folder app/mail
// buka WelcomeMail lalu dibagian content -> return new Content(view: 'mails.welcome'); -> buat folder mails di dalam folder view lalu buat nama file welcome.blade.php

Route::get('/send-welcome-mail', function() {
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
        // Mail::to($user['email'])->send(new WelcomeMail($user));
        // sleep(1);

        // queue
        ProcessWelcomeMail::dispatch($user);
    }

    // for ($i = 0; $i < 11; $i++) {
    //     Mail::to('recipient'.$i.'@mail.com')->send(new WelcomeMail($data));
    //     sleep(1);
    // }
});

//di WelcomeMail envelope tambahkan:
// from: new Address('jeffreyan@example.com', 'Jeffreyan'), (ini untuk mengganti yg global di env)
// ada jg replyTo
// replyTo: [
// new Address('admin-latihan@example.com', 'Admin Latihan')
// ],

// jika ada $data => isi di dalam construct => public $data (kalo public bisa langsung digunakan)
// jika protected $data hrs menambahkan di content
// ex: view: 'mails.welcome', with: ['email' => $this->data['email], 'password' => $this->data['password]]

//attachment di mail => masukkan di return fungsi attachment
// Attachment::fromPath(Storage::url('images/image1.jpg)) //attachment bisa di rename nama jg -> liat dokumentasi


// mail queue
// lihat di env -> queue connection = database
// buat queue => php artisan make:job ProcessWelcomeMail -> file app\jobs