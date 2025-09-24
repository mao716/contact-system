<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
	public function index(Request $request)
	{
		$categories = Category::pluck('content', 'id');

		$q = $this->buildQuery($request);
		$contacts = $q->paginate(7)->withQueryString();

		return view('admin.index', compact('contacts', 'categories', 'request'));
	}

	public function show(Contact $contact)
	{
		$contact->load('category');

		return response()->json([
			'last_name'  => $contact->last_name,
			'first_name' => $contact->first_name,
			'gender'     => (string)$contact->gender, // 1/2/3 を文字列で
			'email'      => $contact->email,
			'tel'        => $contact->tel,
			'address'    => $contact->address,
			'building'   => $contact->building,
			'category'   => optional($contact->category)->content ?? '',
			'detail'     => $contact->detail,
		]);
	}

	public function destroy(Contact $contact)
	{
		$contact->delete();
		return response()->noContent(); // 204
	}

	// ★ 検索条件を共通化（index/export で使う）

	private function buildQuery(Request $request)
	{
		$q = Contact::with('category')->orderByDesc('created_at');

		// キーワード（姓/名/フルネーム/メール）
		if ($kw = trim((string) $request->input('keyword'))) {
			$q->where(function ($qq) use ($kw) {
				$qq->where('email', 'like', "%{$kw}%")
					->orWhere('last_name', 'like', "%{$kw}%")
					->orWhere('first_name', 'like', "%{$kw}%")
					->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$kw}%"])
					->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$kw}%"]);
			});
		}

		// 性別（1/2/3 のときのみ絞り込み）
		if (in_array($request->gender, ['1', '2', '3'], true)) {
			$q->where('gender', $request->gender);
		}

		// お問い合わせの種類
		if ($cid = $request->input('category_id')) {
			$q->where('category_id', $cid);
		}

		// 日付（created_at の日一致）
		if ($date = $request->input('date')) {
			$q->whereDate('created_at', $date);
		}

		return $q;
	}

	// ★ CSVエクスポート（現在の検索条件で全件）

	public function export(Request $request): StreamedResponse
	{
		$q = $this->buildQuery($request);

		$headers = [
			'Content-Type'        => 'text/csv; charset=Shift_JIS',
			'Content-Disposition' => 'attachment; filename="contacts_' . now()->format('Ymd_His') . '.csv"',
			'Cache-Control'       => 'no-store, no-cache, must-revalidate',
		];

		return new StreamedResponse(function () use ($q) {
			$out = fopen('php://output', 'w');

			// ヘッダー
			$head = ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容', '登録日時'];
			fputcsv($out, array_map(fn($v) => mb_convert_encoding($v, 'SJIS-win', 'UTF-8'), $head));

			// データ（大量対応）
			$q->chunkById(100, function ($rows) use ($out) {
				foreach ($rows as $c) {
					$row = [
						trim(($c->last_name ?? '') . '　' . ($c->first_name ?? '')),
						[1 => '男性', 2 => '女性', 3 => 'その他'][$c->gender] ?? '',
						$c->email,
						$c->tel,
						$c->address,
						$c->building,
						optional($c->category)->content,
						$c->detail,
						optional($c->created_at)->format('Y-m-d H:i:s'),
					];
					$row = array_map(fn($v) => mb_convert_encoding((string)$v, 'SJIS-win', 'UTF-8'), $row);
					fputcsv($out, $row);
				}
			});

			fclose($out);
		}, 200, $headers);
	}
}
