@extends('layouts.app')

@section('title', 'Admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-button')
<form method="POST" action="{{ route('logout') }}">
	@csrf
	<button type="submit">logout</button>
</form>
@endsection

@section('content')
<h2>Admin</h2>

<form class="admin-search" action="{{ route('admin.index') }}" method="GET">
	<div class="search-row">
		<input class="input" type="text" name="keyword"
			value="{{ $request->keyword }}"
			placeholder="お名前やメールアドレスを入力してください">

		<select class="select" name="gender">
			<option value="">性別</option>
			<option value="1" @selected($request->gender==='1')>男性</option>
			<option value="2" @selected($request->gender==='2')>女性</option>
			<option value="3" @selected($request->gender==='3')>その他</option>
		</select>

		<select class="select" name="category_id">
			<option value="">お問い合わせの種類</option>
			@foreach($categories as $id => $name)
			<option value="{{ $id }}" @selected((string)$request->category_id===(string)$id)>
				{{ $name }}
			</option>
			@endforeach
		</select>

		<input class="input" type="date" name="date" value="{{ $request->date }}">
		<button class="btn primary" type="submit">検索</button>
		<a class="btn ghost" href="{{ route('admin.index') }}">リセット</a>
	</div>

	<div class="actions-left">
		<button class="btn ghost" type="button" disabled>エクスポート</button>
		{{-- 後でCSV実装時にhrefやformに差し替え --}}
	</div>
</form>

<table class="admin-table">
	<thead>
		<tr>
			<th>お名前</th>
			<th>性別</th>
			<th>メールアドレス</th>
			<th>お問い合わせの種類</th>
			<th class="w-ctl"></th>
		</tr>
	</thead>
	<tbody>
		@forelse($contacts as $c)
		<tr>
			<td>{{ $c->last_name }}　{{ $c->first_name }}</td>
			<td>
				@if($c->gender==1) 男性
				@elseif($c->gender==2) 女性
				@else その他
				@endif
			</td>
			<td>{{ $c->email }}</td>
			<td>{{ optional($c->category)->content }}</td>
			<td class="ctl"><button class="btn ghost sm" type="button" disabled>詳細</button></td>
		</tr>
		@empty
		<tr>
			<td colspan="5" class="empty">データがありません</td>
		</tr>
		@endforelse
	</tbody>
</table>

<div class="pager">
	{{ $contacts->onEachSide(1)->links() }}
</div>
@endsection
