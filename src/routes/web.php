<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController; // ユーザ登録・ログイン用
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [ContactController::class, 'create'])->name('contact.create'); // 入力ページ
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm'); // 確認ページ
Route::post('/store', [ContactController::class, 'store'])->name('contact.store'); // 保存用
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks'); // サンクスページ表示専用

Route::get('/reset', function () {
	session()->forget('contact_input'); // 入力値だけクリア
	return redirect('/'); // 入力フォームにリダイレクト
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('contact.showRegisterForm'); // ユーザー登録ページ
Route::post('/register', [AuthController::class, 'register'])->name('contact.register'); // ユーザー登録ページ
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('contact.showLoginForm'); // ログインページ
Route::post('/login', [AuthController::class, 'login'])->name('contact.login'); // ログインページ
Route::get('/admin', [AdminController::class, 'index'])->name('contact.index'); // 管理画面
