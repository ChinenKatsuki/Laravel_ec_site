税込: ￥{{ floor($total) }}<br>
{{ $address->prefecture_code }}
{{ $address->prefecture_name }}
{{ $address->city }}
{{ $address->address }}
<form action="{{ route('payment.pay') }}" method="POST">
    {{ csrf_field() }}
 <script
     src="https://checkout.stripe.com/checkout.js" class="stripe-button"
     data-key="{{ env('STRIPE_KEY') }}"
     data-amount="{{ floor($total) }}"
     data-name="Stripe決済デモ"
     data-label="決済をする"
     data-description="これはデモ決済です"
     data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
     data-locale="auto"
     data-currency="JPY">
 </script>
</form>
