@extends('layouts.app')

@section('title', 'Admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
	/* このページのモーダルだけに強く適用 */
	#detailModal .modal__overlay {
		background: transparent !important;
	}

	#detailModal .modal__panel {
		position: fixed !important;
		inset: 0 !important;
		/* 上下左右0 */
		margin: auto !important;
		/* 真ん中 */
		transform: none !important;
		width: min(600px, 92vw) !important;
		min-height: 600px !important;
		max-height: 80vh !important;
		overflow-y: auto !important;
		padding: 28px 40px 24px !important;
	}

	#detailModal .modal__grid {
		max-width: 520px !important;
		margin: 12px auto 28px !important;
		/* 中身を中央に */
	}

	#detailModal .modal__actions {
		text-align: center !important;
		/* 削除ボタン中央 */
	}
</style>
@endsection

@section('header-button')
<form method="POST" action="{{ route('logout') }}">
	@csrf
	<button type="submit">logout</button>
</form>
@endsection

@section('content')
<h2>Admin</h2>
<div class="main">
	<form class="admin-search" action="{{ route('admin.index') }}" method="GET">
		<div class="search-row">
			<input class="input" type="text" name="keyword"
				value="{{ $request->keyword }}"
				placeholder="お名前やメールアドレスを入力してください">

			<select class="select select--gender" name="gender">
				<option value="" disable selected hidden>性別</option>
				<option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
				<option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
				<option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
				<option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
			</select>

			<select class="select select--category" name="category_id">
				<option value="" disable selected hidden>お問い合わせの種類</option>
				@foreach ($categories as $id => $name)
				<option value="{{ $id }}" {{ (string)request('category_id') === (string)$id ? 'selected' : '' }}>
					{{ $name }}
				</option>
				@endforeach
			</select>

			<input class="input input--date" type="date" name="date" value="{{ $request->date }}">

			<button class="btn primary" type="submit">検索</button>
			<a class="btn ghost" href="{{ route('admin.index') }}">リセット</a>
		</div>

		{{-- エクスポートとページネーションを同じ列に --}}
		<div class="actions-bar">
			<a class="btn ghost" href="{{ route('admin.export', request()->query()) }}">エクスポート</a>
			<div class="pager">
				{{ $contacts->onEachSide(1)->links('pagination::custom') }}
			</div>
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
				<td class="ctl"><button class="btn ghost sm js-detail" type="button" data-id="{{ $c->id }}">詳細</button></td>
			</tr>
			@empty
			<tr>
				<td colspan="5" class="empty">データがありません</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>

<!-- Modal: 詳細 -->
<div id="contact-modal" class="modal" aria-hidden="true">
	<div class="modal-backdrop js-close"></div>

	<div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
		<button class="modal-close js-close" aria-label="閉じる">×</button>

		<div class="modal-body">
			<dl class="modal-grid">
				<dt>お名前</dt>
				<dd id="m_name"></dd>
				<dt>性別</dt>
				<dd id="m_gender"></dd>
				<dt>メールアドレス</dt>
				<dd id="m_email"></dd>
				<dt>電話番号</dt>
				<dd id="m_tel"></dd>
				<dt>住所</dt>
				<dd id="m_address"></dd>
				<dt>建物名</dt>
				<dd id="m_building"></dd>
				<dt>お問い合わせの種類</dt>
				<dd id="m_category"></dd>
				<dt>お問い合わせ内容</dt>
				<dd id="m_detail" class="prewrap"></dd>
			</dl>
			<div class="modal-footer">
				<form id="deleteForm" method="POST">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn danger">削除</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const modal = document.getElementById('contact-modal');
		const dlg = modal.querySelector('.modal-dialog');
		const delForm = document.getElementById('deleteForm');

		// 詳細ボタン（.js-detail）クリックで取得→表示
		document.querySelectorAll('.js-detail').forEach(btn => {
			btn.addEventListener('click', async () => {
				const id = btn.dataset.id;

				// 詳細取得
				const res = await fetch(`/admin/contacts/${id}`);
				if (!res.ok) return alert('読み込みに失敗しました');
				const data = await res.json();

				// 値を詰め替え
				document.getElementById('m_name').textContent = `${data.last_name}　${data.first_name}`;
				document.getElementById('m_gender').textContent = ({
					1: '男性',
					2: '女性',
					3: 'その他'
				})[data.gender] || '';
				document.getElementById('m_email').textContent = data.email || '';
				document.getElementById('m_tel').textContent = data.tel || '';
				document.getElementById('m_address').textContent = data.address || '';
				document.getElementById('m_building').textContent = data.building || '';
				document.getElementById('m_category').textContent = data.category || '';
				document.getElementById('m_detail').textContent = data.detail || '';

				// 削除フォームのactionをセット
				delForm.action = `/admin/contacts/${id}`;

				openModal();
			});
		});

		function openModal() {
			modal.classList.add('is-open');
			modal.setAttribute('aria-hidden', 'false');
		}

		function closeModal() {
			modal.classList.remove('is-open');
			modal.setAttribute('aria-hidden', 'true');
		}

		// 閉じる
		modal.addEventListener('click', (e) => {
			if (e.target.classList.contains('js-close')) closeModal();
		});
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
		});

		// 削除 → 成功したらリロード（シンプル版）
		delForm.addEventListener('submit', async (e) => {
			e.preventDefault();
			const res = await fetch(delForm.action, {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: new FormData(delForm)
			});
			if (res.ok) {
				location.reload(); // 手早く確実
			} else {
				alert('削除に失敗しました');
			}
		});
	});
</script>

@endsection
