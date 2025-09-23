@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header-button')
<div class="header-btn"></div><a href="{{ route('register') }}">register</a></div>
@endsection

@section('content')
<h2>Login</h2>
<div class="container">
	<div class="auth-hero">
		<div class="login-card">
			<form method="POST" action="{{ route('login') }}">
				@csrf

				<div class="form-row">
					<label for="email">メールアドレス</label>
					<input id="email" type="email" name="email" value="{{ old('email') }}"
						placeholder="例: test@example.com" required autofocus>
					@error('email')
					<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="form-row">
					<label for="password">パスワード</label>
					<input id="password" type="password" name="password"
						placeholder="例: coachtech106" required>
					@error('password')
					<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="actions">
					<button type="submit" class="btn">ログイン</button>
					{{-- 右上のregisterボタンはレイアウト側に置くのでここには置かない --}}
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
