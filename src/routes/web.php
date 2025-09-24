<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
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

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // 今の管理画面

// 仕上げ時
// Route::middleware('auth')->group(function () {
// 	Route::get('/admin', [AdminController::class, 'index'])
// 		->name('admin.index');
// Route::post('/logout', [AuthController::class, 'logout'])
// 		->name('logout');
// });
