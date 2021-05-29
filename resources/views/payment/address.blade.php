
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
<font color="red">
この住所にお届けします
</font>
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
<div align="center">
<a href="{{ route('cart.confirm') }}" class="btn btn-primary btn-xl">注文を確認する>></a>
</div>
<form class="form-horizontal" method="POST" action="{{ route('address.add') }}">
{{ csrf_field() }}
<div align="center">
<h3>新しい住所を登録する</h3>
</div>
@if ($errors->any())
<div class="container mt-4">
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
</div>
@endif

<label class="col-md-4 control-label">性</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="text" name="family_name" class="form-control" value="{{ old('family_name') }}">
</div>

<label class="col-md-4 control-label">名</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
</div>

<label class="col-md-4 control-label">郵便番号</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="type" name="prefecture_code" class="form-control"  value="{{ old('prefecture_code') }}">
</div>

<label class="col-md-4 control-label">都道府県</label>
<div class="col-md-6" style="margin-bottom:20px">
<select name="prefecture_name" class="form-control">
@foreach ($prefectures as $prefecture)
<option value="{{ $prefecture }}" @if (old('prefecture_name') == $prefecture) selected @endif>{{ $prefecture }}</option>
@endforeach
</select>
</div>


<label class="col-md-4 control-label">市町区村</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="text" name="city" class="form-control" value="{{ old('city') }}">
</div>

<label class="col-md-4 control-label">それ以下の住所</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="text" name="address" class="form-control"  value="{{ old('address') }}">
</div>

<label class="col-md-4 control-label">電話番号</label>
<div class="col-md-6" style="margin-bottom:20px">
<input type="text" maxlength="20" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
</div>

<div class="col-sm-offset-4 col-sm-10">
<input  type="submit" class="btn btn-success" value="お届け先新規登録">
</div>
</form>
@endsection
