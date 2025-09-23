<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Contact System')</title>

	<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">

	<!-- 共通CSS -->
	<link rel="stylesheet" href="{{ asset('css/common.css') }}">

	<!-- ページごとのCSSを差し込む -->
	@yield('css')
</head>

<body>
	<header>
		<h1>FashionablyLate</h1>
		<hr>
	</header>
	<main>
		@yield('content')
	</main>
</body>

</html>
