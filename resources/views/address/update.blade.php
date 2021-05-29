@extends('layouts.app')
@section('content')
@if (session('error'))
<div class="container mt-2">
<div class="alert alert-danger">
{{ session('error') }}
</div>
</div>
@endif
<form class="form-horizontal" method="POST" action="{{ route('address.update') }}">
{{ csrf_field() }}
<div align="center">
<input type="hidden" name="id" value="{{ $address->id }}">
<h3>住所変更</h3>
<div style="margin-right:280px">
<label>性</label><br>
</div> <input type="text" name="family_name" style="width:300px" value="{{ $address->family_name }}"><br>
<div style="margin-right:280px">
<label>名</label><br>
</div>
<input type="text" name="last_name" style="width:300px" value="{{ $address->last_name }}"><br>
<div style="margin-right:240px">
<label>郵便番号</label><br>
</div>
<input type="type" name="prefecture_code" style="width:300px" value="{{ $address->prefecture_code }}"><br>
<div style="margin-right:240px">
<label>都道府県</label><br>
</div>
<select name="prefecture_name" style="width:300px; height:30px">
@if (empty(old('prefecture_name')))
<option value="{{ $address->prefecture_name }}" style="display:none;">{{ $address->prefecture_name }}</option>
@endif
@foreach ($prefectures as $prefecture)
<option value="{{ $prefecture }}" @if (old('prefecture_name') == $prefecture) selected @endif>{{ $prefecture }}</option>
@endforeach
</select>
<div style="margin-right:240px">
<label>市町区村</label><br>
</div>
<input type="text" name="city" style="width:300px" value="{{ $address->city }}"><br>
<div style="margin-right:210px">
<label>それ以下の住所</label><br>
</div>
<input type="text" name="address" style="width:300px" value="{{ $address->address }}"><br>
<div style="margin-right:240px">
<label>電話番号</label><br>
</div>
<input type="text" name="phone_number" style="width:300px" value="{{ $address->phone_number }}"><br>
<br>
@if ($errors->any())
<div class="container mt-2">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<input type="submit" value="変更"><br>
</form>
<a href="{{ route('address.index') }}">前のページに戻る</a>
@endsection
