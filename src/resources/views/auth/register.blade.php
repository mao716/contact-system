@extends('layouts.app')

@section('title', 'Register')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header-button')
<a href="{{ route('login') }}">login</a>
@endsection

@section('content')
<h2>Register</h2>
<div class="container">
	<div class="auth-hero">
		<div class="login-card">
			<form method="POST" action="{{ route('register') }}">
				@csrf

				<div class="form-row">
					<label for="">お名前</label>
					<input id="name" type="text" name="name" value="{{ old('name') }}"
						placeholder="例: 山田　太郎">
					@error('name')
					<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="form-row">
					<label for="email">メールアドレス</label>
					<input id="email" type="email" name="email" value="{{ old('email') }}"
						placeholder="例: test@example.com">
					@error('email')
					<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="form-row">
					<label for="password">パスワード</label>
					<input id="password" type="password" name="password"
						placeholder="例: coachtech1106">
					@error('password')
					<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="actions">
					<button type="submit" class="btn">登録</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
