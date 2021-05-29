@extends('layouts.app_admin')
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
画像を設定していません
@endif
</td>
<td>{{ $item->explain }}</td>
<td>{{ $item->price }}円</td>
<td>
@if ($item->stock > 0)
在庫あり
@elseif ($item->stock === 0)
在庫無し
@endif
</td>
</tr>
<tbody>
</table>
<a href="{{ route('admin.item') }}">商品一覧ページに戻る</a>
<a href="{{ route('item.edit', ['id' => $item->id]) }}">編集する</a>
@endsection
