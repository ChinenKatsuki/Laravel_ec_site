@extends('layouts.app')
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
<h3>注文履歴</h3>
@if (empty($exist))
注文履歴がありません
@else
<thead>
<tr>
<th>商品情報</th>
<th>お届け先住所</th>
<th>購入日時</th>
<th>配送状況</th>
<th>商品レビュー</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
<tr>
<td>
{{ $item->name }}
</td>
<td>
{{ $item->prefecture_name }}
{{ $item->city }}
{{ $item->address }}
</td>
<td>
{{ $item->created_at }}
</td>
<td>
@if ($item->deliver_status == 0)
発送準備中
<form method="post" action="{{ route('payment.cancel') }}">
{{ csrf_field() }}
<input type="number" name="quantity" value="{{ $item->quantity }}">
<input type="hidden" name="order_id" value="{{ $item->id }}">
<input type="hidden" name="item_id" value="{{ $item->item_id }}">
<input type="submit" value="返品する">
</form>
@endif
@if ($item->deliver_status == 1)
発送済み
@endif
</td>
<td>
@foreach ($reviews as $review)
@if ($item->item_id != $review->item_id)
<a href="{{ route('review.create', ['id' => $item->item_id]) }}">レビューする</a>
@endif
@endforeach
</td>
</tr>
@endforeach
</tbody>
</div>
</table>
<div align="right" style="margin-right:100px">
合計<br>
税込: ￥{{ number_format($total) }}
</div>
@endif
@endsection
