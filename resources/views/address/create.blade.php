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

<form class="form-horizontal" method="POST" action="{{ route('address.add') }}">
{{ csrf_field() }}
<div align="center">
<h3>新しい住所を登録する</h3>
<div style="margin-right:280px">
<label>性</label><br>
</div>
<input type="text" name="family_name" value="{{ old('family_name') }}" style="width:300px"><br>
<div style="margin-right:280px">
<label>名</label><br>
</div>
<input type="text" name="last_name" value="{{ old('last_name') }}" style="width:300px"><br>
<div style="margin-right:240px">
<label>郵便番号</label><br>
</div>
<input type="type" name="prefecture_code" value="{{ old('prefecture_code') }}"style="width:300px"><br>
<div style="margin-right:240px">
<label>都道府県</label><br>
</div>
<select name="prefecture_name" style="width:300px; height:30px">
@foreach ($prefectures as $prefecture)
<option value="{{ $prefecture }}" @if (old('prefecture_name') == $prefecture) selected @endif>{{ $prefecture }}</option>
@endforeach
</select>
<div style="margin-right:240px">
<label>市町区村</label><br>
</div>
<input type="text" name="city" value="{{ old('city') }}"style="width:300px"><br>
<div style="margin-right:210px">
<label>それ以下の住所</label><br>
</div>
<input type="text" name="address" value="{{ old('address') }}"style="width:300px"><br>
<div style="margin-right:240px">
<label>電話番号</label><br>
</div>
<input type="text" maxlength="20" name="phone_number" value="{{ old('phone_number') }}"style="width:300px"><br>
<br>
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
<input type="submit" value="登録"><br>
</form>
<a href="{{ route('address.index') }}">前のページに戻る</a>
@endsection
