@extends('layouts.app_admin')
@section('content')
<h1>商品新規追加完了</h1>
<div class="alert alert-primary" role="alert">
新規追加しました。
<a href="{{ route('admin.item') }}" class="btn btn-primary">一覧に戻る</a>
</div>
@endsection

