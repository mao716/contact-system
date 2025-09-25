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

// --- 問い合わせフォーム --- //
Route::get('/', [ContactController::class, 'create'])->name('contact.create'); // 入力ページ
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm'); // 確認ページ
Route::post('/store', [ContactController::class, 'store'])->name('contact.store'); // DB保存用
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks'); // サンクスページ表示

Route::get('/reset', function () {
	session()->forget('contact_input'); // 入力値だけクリア
	return redirect('/'); // 入力フォームにリダイレクト
});

// --- 管理画面（要ログイン） --- //
Route::middleware('auth')->group(function () {
	Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
	Route::get('/admin/contacts/{contact}', [AdminController::class, 'show'])
		->name('admin.contacts.show');
	Route::delete('/admin/contacts/{contact}', [AdminController::class, 'destroy'])
		->name('admin.contacts.destroy');
	Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
});
