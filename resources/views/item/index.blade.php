@extends('layouts.app')
@section('content')
@if (session('message'))
<div class="container mt-2">
<div class="alert alert-success">
{{ session('message') }}
</div>
</div>
@endif
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
