<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>サンクスページ</title>
	<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
	<link rel="stylesheet" href="{{ asset('css/common.css') }}">
	<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>
	<div class="thanks-wrap">
		<h1 class="thanks-bg" aria-hidden="true">Thank&nbsp;you</h1>
		<div class="thanks-main">
			<p class="thanks-message">お問い合わせありがとうございました</p>
			<a href="{{ route('contact.create') }}" class="home-btn">HOME</a>
		</div>
	</div>
</body>

</html>
