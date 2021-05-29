@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">アカウント情報</div>

@if (session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

<label>名前</label>
<div>
{{$auth->name}}
<a href="{{ route('user.edit.name') }}">編集</a>
</div>

<label>メールアドレス</label>
<div>
{{$auth->email}}
<a href="{{ route('user.edit.email') }}">編集</a>
</div>

<label>パスワード</label>
<div>
パスワードは安全の為表示できません
<a href="{{ route('user.edit.password') }}">編集</a>
</div>

</div>
</div>
</div>
</div>
@endsection
