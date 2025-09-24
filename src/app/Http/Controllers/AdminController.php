<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
	public function index(Request $request)
	{
		$categories = Category::pluck('content', 'id');

		$q = Contact::with('category')->orderByDesc('created_at');

		// キーワード（名前/メール部分一致）※姓名/フルネーム両対応
		if ($kw = trim($request->input('keyword'))) {
			$q->where(function ($qq) use ($kw) {
				$qq->where('email', 'like', "%{$kw}%")
					->orWhere('last_name', 'like', "%{$kw}%")
					->orWhere('first_name', 'like', "%{$kw}%")
					->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$kw}%"])
					->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$kw}%"]);
			});
		}

		// 性別（1:男性,2:女性,3:その他）
		if (in_array($request->gender, ['1', '2', '3'], true)) {
			$q->where('gender', $request->gender);
		}

		// お問い合わせの種類
		if ($cid = $request->input('category_id')) {
			$q->where('category_id', $cid);
		}

		// 日付（created_atの“日”一致）
		if ($date = $request->input('date')) {
			$q->whereDate('created_at', $date);
		}

		$contacts = $q->paginate(7)->withQueryString();

		return view('admin.index', compact('contacts', 'categories', 'request'));
	}
}
