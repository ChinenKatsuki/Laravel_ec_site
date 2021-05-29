@extends('layouts.app')
@section('content')
<table class="table">
<thead>
<tr>
<th>商品名</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
<tr>
<td>
<a href="{{ route('detail.show', ['id' => $item->id]) }}">{{ $item->name }}</a>
</td>
<td>{{ $item->price }}円</td>
<td>
@if ($item->stock > 0)
在庫あり
@elseif ($item->stock === 0)
在庫無し
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
