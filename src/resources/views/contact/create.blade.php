<!DOCTYPE html>
@extends('layouts.app')

@section('title')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="container">
	<h2>Contact</h2>

	<form action="{{ route('contact.confirm') }}" method="post" novalidate>
		@csrf

		<!-- お名前 -->
		<div class="form-row">
			<div class="form-label">お名前 <span class="req">※</span></div>
			<div class="form-field inline name-inline">
				<div>
					<input id="last_name" type="text" name="last_name" value="{{ old('last_name', $saved['last_name'] ?? '') }}" placeholder="例：山田">
					@error('last_name')
					<div class="error">{{ $message }}</div>
					@enderror
				</div>
				<div>
					<input id="first_name" type="text" name="first_name" value="{{ old('first_name', $saved['first_name'] ?? '') }}" placeholder="例：太郎">
					@error('first_name')
					<div class="error">{{ $message }}</div>
					@enderror
				</div>
			</div>
		</div>

		<!-- 性別 -->
		<div class="form-row">
			<div class="form-label">性別 <span class="req">※</span></div>
			<div class="form-field">
				<div class="inline">
					<label><input type="radio" name="gender" value="1" {{ old('gender', $saved['gender'] ?? '') == '1' ? 'checked' : '' }}> 男性</label>
					<label><input type="radio" name="gender" value="2" {{ old('gender', $saved['gender'] ?? '') == '2' ? 'checked' : '' }}> 女性</label>
					<label><input type="radio" name="gender" value="3" {{ old('gender', $saved['gender'] ?? '') == '3' ? 'checked' : '' }}> その他</label>
				</div>
				@error('gender')
				<div class="error">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<!-- メールアドレス -->
		<div class="form-row">
			<div class="form-label">メールアドレス <span class="req">※</span></div>
			<div class="form-field">
				<input type="email" name="email" value="{{ old('email', $saved['email'] ?? '') }}" placeholder="例：test@example.com">
				@error('email')
				<div class="error">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<!-- 電話番号（3分割） -->
		<div class="form-row">
			<div class="form-label">電話番号 <span class="req">※</span></div>
			<div class="form-field inline tel-split">
				<div>
					<input type="text" name="tel1" value="{{ old('tel1', $saved['tel1'] ?? '') }}" placeholder="080">
					@error('tel1')
					<div class="error">{{ $message }}</div>
					@enderror
				</div>
				<span class="separator">-</span>
				<div><input type="text" name="tel2" value="{{ old('tel2', $saved['tel2'] ?? '') }}" placeholder="1234">
					@error('tel2')
					<div class="error">{{ $message }}</div>
					@enderror
				</div>
				<span class="separator">-</span>
				<div>
					<input type="text" name="tel3" value="{{ old('tel3', $saved['tel3'] ?? '') }}" placeholder="5678">
					@error('tel3')
					<div class="error">{{ $message }}</div>
					@enderror
				</div>
			</div>
		</div>

		<!-- 住所 -->
		<div class="form-row">
			<div class="form-label">住所 <span class="req">※</span></div>
			<div class="form-field">
				<input type="text" name="address" value="{{ old('address', $saved['address'] ?? '') }}" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3">
				@error('address')
				<div class="error">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<!-- 建物名（任意） -->
		<div class="form-row">
			<div class="form-label">建物名</div>
			<div class="form-field">
				<input type="text" name="building" value="{{ old('building', $saved['building'] ?? '') }}" placeholder=" 例：千駄ヶ谷マンション101">
			</div>
		</div>

		<!-- お問い合わせの種類 -->
		<div class="form-row">
			<div class="form-label">お問い合わせの種類 <span class="req">※</span></div>
			<div class="form-field">
				<select name="category_id">
					<option value="" disabled
						{{ old('category_id', $saved['category_id'] ?? null) === null ? 'selected' : '' }} hidden>
						選択してください
					</option>
					@foreach($categories as $id => $name)
					<option value="{{ $id }}"
						{{ (string)old('category_id', (string)($saved['category_id'] ?? '')) === (string)$id ? 'selected' : '' }}>
						{{ $name }}
					</option>
					@endforeach
				</select>
				@error('category_id')
				<div class="error">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<!-- お問い合わせ内容 -->
		<div class="form-row">
			<div class="form-label">お問い合わせ内容 <span class="req">※</span></div>
			<div class="form-field">
				<textarea name="detail" rows="6" placeholder="お問い合わせ内容をご記載ください">{{ old('detail', $saved['detail'] ?? '') }}</textarea>
				@error('detail')
				<div class="error">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="submit-area">
			<button class="btn" type="submit">確認画面</button>
		</div>
	</form>
</div>
@endsection
