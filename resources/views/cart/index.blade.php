@extends('layouts.app')
@section('content')
<a href="{{ route('address.index') }}">お届け先選択</a><br>
@if (0 < $carts->count())
@if (session('message'))
<div class="container mt-2">
<div class="alert alert-success">
{{ session('message') }}
</div>
</div>
@endif
<table class="table">
<thead>
<tr>
<th>商品名</th>
<th>価格</th>
<th>購入数</th>
</tr>
</thead>
<tbody>
@foreach($carts as $cart)
<tr>
<td>{{ $cart->name }}</td>
<td>¥{{ $cart->price }}</td>
<td>{{ $cart->quantity }}</td>
<td>
<form class="form-horizontal" method="POST" action="{{ route('item.delete') }}">
{{ csrf_field() }}
<input type="hidden" name="id" value="{{ $cart->id }}">
<button type="submit" class="btn btn-primary">
注文をキャンセルする
</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
<div align="right" style="margin-right:100px">
合計<br>
¥{{ number_format($subtotal) }}<br>
税込: ￥{{ number_format($total) }}
</div>
<div align="right" style="margin-right:700px">
@if ($address)
<a href="{{ route('address.select') }}" class="btn btn-warning btn-xl">レジに進む</a>
@else
<a href="{{ route('address.index') }}" class="btn btn-warning btn-xl">お届け先住所を登録する</a>
@endif
@else
<h1>カートが空です</h1>
@endif
@endsection
