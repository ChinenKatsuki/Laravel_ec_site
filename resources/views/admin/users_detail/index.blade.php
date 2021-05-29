@extends('layouts.app_admin')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">ユーザー名</div>
@if (session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif
@foreach($users as $user)
・<a href="{{ route('admin.user.detail', ['id' => $user->id]) }}">{{ $user->name }}</a><br>
@endforeach
<a href="{{ route('admin.item') }}">アイテム一覧に戻る</a>
</div>
</div>
</div>
</div>
@endsection
