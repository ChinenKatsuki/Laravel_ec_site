@extends('layouts.app_admin')
@section('content')
<h1>商品内容編集完了</h1>
<div class="alert alert-primary" role="alert">
編集しました。
<a href="{{ route('admin.item') }}" class="btn btn-primary">商品一覧に戻る</a>
</div>
@endsection
