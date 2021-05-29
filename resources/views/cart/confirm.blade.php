@extends('layouts.app')
@section('content')
<table class="table">
<h2>注文内容の確認</h2>
<h3>購入内容</h3>
<thead>
<tr>
<th>商品名</th>
<th>価格</th>
<th>購入数</th>
</tr>
</thead>
<tbody>
@foreach($carts as $cart)
<tr>
<td>{{ $cart->name }}</td>
<td>¥{{ $cart->price }}</td>
<td>{{ $cart->quantity }}</td>
@endforeach
</tbody>
</table>
<div align="right" style="margin-right:100px">
合計<br>
¥{{ number_format($subtotal) }}<br>
税込: ￥{{ number_format($total) }}
</div>
<table class="table">
<h3>お届け先住所</h3>
<thead>
<tr>
<th>氏名</th>
<th>郵便番号</th>
<th>都道府県</th>
<th>市町村</th>
<th>それ以下の住所</th>
<th>電話番号</th>
</tr>
</thead>
<tbody>
<tr>
<td>
{{ $address->family_name }}
{{ $address->last_name }}
</td>
<td>{{ substr($address->prefecture_code, 0, 3) }}-{{ substr($address->prefecture_code, -4) }}</td>
<td>{{ $address->prefecture_name }}</td>
<td>{{ $address->city }}</td>
<td>{{ $address->address }}</td>
<td>{{ $address->phone_number }}</td>
</tr>
</tbody>
</table>
<div align="center">
<form action="{{ route('payment.pay') }}" method="POST">
    {{ csrf_field() }}
 <script
     src="https://checkout.stripe.com/checkout.js" class="stripe-button"
     data-key="{{ config('stripe.STRIPE_KEY') }}"
     data-amount="{{ number_format($total) }}"
     data-name="Stripe決済デモ"
     data-label="決済をする"
     data-description="これはデモ決済です"
     data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
     data-locale="auto"
     data-currency="JPY">
 </script>
</form>
</div>
@endsection
