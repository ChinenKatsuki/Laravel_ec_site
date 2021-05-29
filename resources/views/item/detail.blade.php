@extends('layouts.app')
@section('content')
<table class="table">
<thead>
<tr>
<th>商品名</th>
<th>商品画像</th>
<th>商品説明</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>
</thead>
<tbody>
<tr>
<td>{{ $item->name }}</td>
<td>
@if ($item->image_name)
<img src="{{ asset('storage/item_images/' . $item->image_name) }}" width="100" height="100"><br>
@else
画像は今準備中です
@endif
</td>
<td>{{ $item->explain }}</td>
<td>
¥{{ $item->price }}<br>
</td>
<td>
@if ($item->stock > 0)
在庫あり
@if (Auth::id())
<td><a href="{{ route('item.add.cart', ['id' => $item->id]) }}">カートに入れる</a></td>
@endif
@elseif ($item->stock === 0)
在庫無し
@endif
</td>
</tr>
<tbody>
</table>
<a href="{{ route('user.page') }}">商品一覧ページに戻る</a>
@if (!$reviews->isEmpty())
<table class="table">
<thead>
<tr>
<th>ユーザー名</th>
<th>評価</th>
<th>コメント</th>
</tr>
</thead>
<tbody>
@foreach ($reviews as $review)
<tr>
<td>{{ $review->name }}</td>
<td>{{ config('score')[$review->score] }}</td>
<td>{{ $review->comment }}</td><br>
@endforeach
</tbody>
</table>
@endif
@endsection
