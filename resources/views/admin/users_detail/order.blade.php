@extends('layouts.app_admin')
@section('content')
@if (session('success'))
<div class="container mt-2">
<div class="alert alert-success">
{{ session('success') }}
</div>
</div>
@endif
@if (session('error'))
<div class="container mt-2">
<div class="alert alert-danger">
{{ session('error') }}
</div>
</div>
@endif
<h3>注文履歴</h3>
<form method="post" action="{{ route('admin.user.order') }}" method="post">
{{ csrf_field() }}
注文開始日 &emsp; &emsp; &emsp; &emsp; &emsp; &thinsp; 注文終了日<br>
<input type="date" name="start_date" value="{{ $start_date }}">〜
<input type="date" name="end_date" value="{{ $end_date }}"><br>
ユーザー名<br>
<input type="text" name="user_name" value="{{ $user_name }}"><br>
<input type="submit" value="検索"><br>
</form>
<form method="post" action="{{ route('admin.user.order.csv') }}" method="post">
{{ csrf_field() }}
<input type="hidden" name="start_date" value="{{ $start_date }}">
<input type="hidden" name="end_date" value="{{ $end_date }}">
<input type="hidden" name="user_name" value="{{ $user_name }}">
<input type="submit" value="csvを出力する">
</form>
<table class="table">
<thead>
<tr>
<th>注文日</th>
<th>お届け先の氏名</th>
<th>合計金額</th>
</tr>
</thead>
<tbody>
@foreach($order_serches as $order_serch)
<tr>
<td>
{{ $order_serch->id }}
{{ $order_serch->created_at }}
</td>
<td>
{{ $order_serch->family_name }}
{{ $order_serch->last_name }}
</td>
<td>
￥{{ number_format($order_serch->price) }}
<a href="{{ route('user.order.detail', ['id' => $order_serch->id]) }}">注文の詳細</a>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
