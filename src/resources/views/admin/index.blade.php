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


@endsection
