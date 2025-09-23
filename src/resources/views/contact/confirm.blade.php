<!DOCTYPE html>
@extends('layouts.app')

@section('title')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="container">
	<h2>Confirm</h2>
	<table class="table">
		<tr>
			<th>お名前</th>
			<td>{{ $data['last_name'] }}　{{ $data['first_name'] }}</td>
		</tr>
		<tr>
			<th>性別</th>
			<td>{{ $data['gender_label'] }}</td> <!-- 1/2/3 を「男性/女性/その他」に変換済み -->
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>{{ $data['email'] }}</td>
		</tr>
		<tr>
			<th>電話番号</th>
			<td>{{ $data['tel_full'] }}</td> <!-- 080-1234-5678 の結合文字列 -->
		</tr>
		<tr>
			<th>住所</th>
			<td>{{ $data['address'] }}</td>
		</tr>
		<tr>
			<th>建物名</th>
			<td>{{ $data['building'] ?? '' }}</td> <!--  null なら空表示 -->
		</tr>
		<tr>
			<th>お問い合わせの種類</th>
			<td>{{ $data['category_name'] }}</td> <!-- id をカテゴリ名に変換済み -->
		</tr>
		<tr>
			<th>お問い合わせ内容</th>
			<td>{!! nl2br(e($data['detail'])) !!}</td> <!-- 改行を<br>に変換して安全に表示 -->
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
@endsection
