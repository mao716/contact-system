<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirm</title>
	<style>
		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 40px 20px;
		}

		h1 {
			text-align: center;
			font-weight: 600;
		}

		h2 {
			text-align: center;
			margin: 24px 0 36px;
		}

		.table {
			width: 100%;
			border-collapse: collapse;
			margin: 0 auto;
		}

		.table th,
		.table td {
			border-bottom: 1px solid #e6e0da;
			padding: 18px 30px;
		}

		.table th {
			width: 190px;
			background: #bca999;
			color: #fff;
			text-align: left;
		}

		/*
		.table tr:last-child th,
		.table tr:last-child td {
			border-bottom: none;
		}
		*/

		.actions {
			text-align: center;
			margin-top: 28px;
			display: flex;
			gap: 28px;
			justify-content: center;
		}

		.btn {
			padding: 8px 36px;
			border: 0;
			border-radius: 2px;
			background: #8e7b6d;
			color: #fff;
		}

		.link {
			font-size: 14px;
			color: #6c645c;
			text-decoration: underline;
		}

		hr {
			border: 0;
			border-top: 1px solid #eee;
			margin: 18px 0 40px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>FashionablyLate</h1>
		<hr />
		<h2>Confirm</h2>

		{{-- ここで $data を表示する。create→POST /confirm で作った配列 --}}
		<table class="table">
			<tr>
				<th>お名前</th>
				<td>{{ $data['last_name'] }}　{{ $data['first_name'] }}</td> {{-- 姓名の間に全角スペース --}}
			</tr>
			<tr>
				<th>性別</th>
				<td>{{ $data['gender_label'] }}</td> {{-- 1/2/3 を「男性/女性/その他」に変換済み --}}
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td>{{ $data['email'] }}</td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td>{{ $data['tel_full'] }}</td> {{-- 080-1234-5678 の結合文字列 --}}
			</tr>
			<tr>
				<th>住所</th>
				<td>{{ $data['address'] }}</td>
			</tr>
			<tr>
				<th>建物名</th>
				<td>{{ $data['building'] ?? '' }}</td> {{-- 任意項目なので null なら空表示 --}}
			</tr>
			<tr>
				<th>お問い合わせの種類</th>
				<td>{{ $data['category_name'] }}</td> {{-- id をカテゴリ名に変換済み --}}
			</tr>
			<tr>
				<th>お問い合わせ内容</th>
				<td>{!! nl2br(e($data['detail'])) !!}</td> {{-- 改行を<br>に変換して安全に表示 --}}
			</tr>
		</table>

		<div class="actions">
			{{-- 送信：DB保存用に POST /thanks --}}
			<form action="{{ route('contact.store') }}" method="post">
				@csrf
				<button type="submit" class="btn">送信</button>
			</form>

			{{-- 修正：入力画面へ戻る（セッション保持で値が入った状態になる） --}}
			<a class="link" href="{{ route('contact.create') }}">修正</a>
		</div>
	</div>
</body>

</html>
