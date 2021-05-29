@extends('layouts.app_admin')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">ユーザー情報詳細</div>
<label>ユーザー名</label><br>
{{ $user->name }}<br>
<label>メールアドレス</label><br>
{{ $user->email }}<br>
<label>住所</label><br>
@if ($addresses->count())
@foreach ($addresses as $address)
{{ substr($address->prefecture_code, 0, 3) }}-{{ substr($address->prefecture_code, -4) }}
{{ $address->prefecture_name }}
{{ $address->city }}
{{ $address->address }}<br>
@endforeach
@else
まだお届け先住所を登録していません<br>
@endif
<a href="{{ route('admin.user.index') }}">前のページに戻る</a>
</div>
</div>
</div>
</div>
@endsection
