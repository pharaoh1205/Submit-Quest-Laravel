<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;


Route::get('/editor', [ArticleController::class, 'create'])->name('articles.create');

Route::post('/editor/', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/', [ArticleController::class, 'index'])->name('home');

Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');


Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');


// 更新保存処理を受け取るルート
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');

Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');


// Edit 画面 (Create画面と同じテンプレートを使用)
Route::get('/editor/{slug}', function (){
    return view('editor');
});

// Article 画面
Route::get('/article/{slug}', function (){
    return view('article');
});


// Sign In ページ
Route::get('/signin', function (){
    return view('auth.signin');
});

// Sign Up ページ
Route::get('/signup', function (){
    return view('auth.signup');
});



// ログイン画面表示
Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');

// ログイン処理（フォーム送信先）
Route::post('/signin', [AuthController::class, 'signin']);

// Signup 画面表示
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');

// Signup 登録処理の受付
Route::post('/signup', [AuthController::class, 'signup']);


// Home 画面（記事一覧）
Route::get('/', [ArticleController::class, 'index'])->name('home');

// Article 画面（記事詳細）
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');