@extends('layouts.app')
@section('content')
@if (session('message'))
<div class="container mt-2">
<div class="alert alert-success">
{{ session('message') }}
</div>
</div>
@endif
<table class="table">
<div align="center">
<h3>お客様のご住所</h3>
<a href="{{ route('address.create') }}">住所追加</a><br>
<thead>
<tr>
<th>送り先の選択</th>
<th>氏名</th>
<th>郵便番号</th>
<th>都道府県</th>
<th>市町村</th>
<th>それ以下の住所</th>
<th>電話番号</th>
</tr>
</thead>
<tbody>
@foreach ($addresses as $address)
<tr>
<td>
<input type="radio" name="id" value="{{ $address->id }}">
</td>
<td>
{{ $address->family_name }}
{{ $address->last_name }}
</td>
<td>{{ $address->prefecture_code }}</td>
<td>{{ $address->prefecture_name }}</td>
<td>{{ $address->city }}</td>
<td>{{ $address->address }}</td>
<td>{{ $address->phone_number }}</td>
<td>
<a href="{{ route('address.edit', ['id' => $address->id]) }}">s</a>
<button  class="btn btn-primary btn-xs" type="submit">編集</button>
<button class="btn btn-danger btn-xs" type="submit">削除</button>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
