@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
                <div class="panel-heading">パスワードの変更</div>
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

			<form method="post" action="{{ route('user.update.password') }}">
			{{ csrf_field() }}
			<label>現在のパスワード</label><br>
			<input type="password" name="old_password"><br>
			<label>新パスワード</label><br>
			<input type="password" name="password"><br>
			<label>新パスワード(確認)</label><br>
			<input type="password" name="password_confirmation"><br>
			<input type="submit" class="btn btn-primary btn-xs" value="変更"><br>
			</form>
			<a href="{{ route('user.index') }}">前のページに戻る</a>
		</div>
	</div>
</div>
@endsection
