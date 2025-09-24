<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
	public function create()
	{
		$saved = session('contact_input', []); // 修正用の一時値
		$categories = Category::pluck('content', 'id'); // [id => "カテゴリ名"]

		// resources/views/contact/create.blade.php を表示する
		return view('contact.create', compact('saved', 'categories'));
	}

	public function confirm(ContactRequest $request)
	{
		// バリデーション通過済みの値だけ取得
		$data = $request->validated();

		// 性別ラベル
		$genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];
		$data['gender_label'] = $genderLabels[$data['gender']];

		// 電話番号を結合
		$tel = $data['tel1'] . '-' . $data['tel2'] . '-' . $data['tel3'];
		$data['tel_full'] = $tel; // confirm表示用
		$data['tel'] = $tel; // DB保存用

		// カテゴリ名
		$data['category_name'] = Category::whereKey($data['category_id'])->value('content') ?? '';

		// 修正戻り用
		session(['contact_input' => $data]);

		return view('contact.confirm', compact('data'));
	}

	public function store()
	{
		$input = session('contact_input'); // confirm() で詰めた一時データを取り出し
		if (empty($input)) {
			return redirect()->route('contact.create');
		}

		// DB保存
		Contact::create([
			'last_name'   => $input['last_name'],
			'first_name'  => $input['first_name'],
			'gender'      => $input['gender'],
			'email'       => $input['email'],
			'tel'         => $input['tel'], // confirmで整形済み
			'address'     => $input['address'],
			'building'    => $input['building'] ?? null,
			'detail'      => $input['detail'],
			'category_id' => $input['category_id'],
		]);

		// 一時データを破棄してから thanks へ（PRG）
		session()->forget('contact_input');

		return redirect()->route('contact.thanks');
	}

	public function thanks()
	{
		return view('contact.thanks');
	}
}
