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
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<a href="{{ route('item.create') }}" class="btn btn-primary btn-xs">商品を追加</a><br>
<a href="{{ route('admin.item.csv') }}" class="btn btn-primary btn-xs">csv出力する</a><br>
<form method="POST" action="{{ route('admin.csv.upload') }}" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="file" name="csv_file">
<button type="submit">csvアップロード</button>
</form>
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
<a href="{{ route('admin_detail.show', ['id' => $item->id]) }}">{{ $item->name }}</a>
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
