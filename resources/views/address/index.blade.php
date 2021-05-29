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
<div align="center">
<h3>お客様のご住所</h3>
<a href="{{ route('address.create') }}">住所追加</a><br>

@if ($addresses->isEmpty())
住所未登録
@else
<thead>
<tr>
<th>お届け先の選択</th>
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
@if ($address->deliver_flag == 1)
この住所にお届けします
@else
<a href="{{ route('address.deliver', ['id' => $address->id]) }}" class="btn btn-warning btn-xs">この住所に届ける</a>
@endif
</td>
<td>
{{ $address->family_name }}
{{ $address->last_name }}
</td>
<td>{{ substr($address->prefecture_code, 0, 3) }}-{{ substr($address->prefecture_code, -4) }}</td>
<td>{{ $address->prefecture_name }}</td>
<td>{{ $address->city }}</td>
<td>{{ $address->address }}</td>
<td>{{ $address->phone_number }}</td>
<td>
<a href="{{ route('address.edit', ['id' => $address->id]) }}" class="btn btn-primary btn-xs">編集</a>
<a href="{{ route('address.delete', ['id' => $address->id]) }}" class="btn btn-danger btn-xs">削除</a>
</form>
</td>
</tr>
@endforeach
</tbody>
@endif
</table>
@endsection
