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
<table class="table">
<h3>注文詳細</h3>
<thead>
<tr>
<th>注文日</th>
<th>お届け先情報</th>
<th>商品情報</th>
</tr>
</thead>
<tbody>
@foreach($details as $detail)
<tr>
<td>

{{ $detail->created_at }}
</td>
<td>
{{ $detail->prefecture_name }}
{{ $detail->city }}
{{ $detail->address }}
</td>
<td>
商品名：{{ $detail->name }}<br>
商品価格：¥{{ $detail->price }}<br>
注文個数：{{ $detail->quantity }}個<br>
</td>
<td>
@if ($detail->deliver_status == 0)
発送準備中
@endif
@if ($detail->deliver_status == 1)
発送済み
@endif
@if ($detail->deliver_status == 2)
キャンセル
@endif
@if ($detail->deliver_status == 0)
<form action="{{ route('deliver_status.change', ['id' => $detail->user_id]) }}" method="post">
{{ csrf_field() }}
<select name="deliver_status">
<option value="1">発送済み</option>
</select>
<input type="hidden" name="item_id" value="{{ $detail->item_id }}">
<input type="hidden" name="order_id" value="{{ $detail->order_id }}">
<input type="submit" value="変更">
</form>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
<div align="right" style="margin-right:100px">
合計<br>
税込: ￥{{ number_format($total->price) }}
</div>
@endsection
