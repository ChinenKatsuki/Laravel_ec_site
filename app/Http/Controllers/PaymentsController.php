<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Review;
use App\Address;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Refund;

class PaymentsController extends Controller {

	public function index() {
		$subtotal = Cart::where('user_id', Auth::id())->sum(DB::raw('price * quantity'));
		$total = floor($subtotal * 1.1);
		$address = Address::where('user_id', Auth::id())->where('deliver_flag', 1)->first();
		return view('payment.index', compact('total', 'address'));
	}

	public function pay(Request $request) {
		$subtotal = Cart::where('user_id', Auth::id())->sum(DB::raw('price * quantity'));
		$total = floor($subtotal * 1.1);
		if ($total) {
			Stripe::setApiKey(config('stripe.STRIPE_SECRET'));
			$charge_id = null;
			try {
				$customer = Customer::create(array(
					'email' => $request->stripeEmail,
					'source' => $request->stripeToken
				));
				$charge = Charge::create(array(
					'customer' => $customer->id,
					'amount' => $total,
					'currency' => 'jpy'
				));
				$charge_id = $charge['id'];
				$payment = new Payment;
				$payment->stripe_id = $charge->id;
				$payment->user_id = Auth::id();
				$payment->price = $total;
				$payment->save();

				$address = Address::where('user_id', Auth::id())->where('deliver_flag', 1)->first();
				$payment_id = Payment::where('user_id', Auth::id())->where('stripe_id', $charge->id)->first();
				$order = new Order;
				$order->user_id = Auth::id();
				$order->payment_id = $payment_id->id;
				$order->family_name = $address->family_name;
				$order->last_name = $address->last_name;
				$order->prefecture_code = $address->prefecture_code;
				$order->prefecture_name = $address->prefecture_name;
				$order->city = $address->city;
				$order->address = $address->address;
				$order->save();

				$carts = Cart::where('user_id', Auth::id())->get();
				$order = Order::where('user_id', Auth::id())->where('payment_id', $payment_id->id)->first();
				foreach ($carts as $cart) {
					$order_detail = new Order_detail;
					$order_detail->order_id = $order->id;
					$order_detail->item_id = $cart->item_id;
					$order_detail->quantity = $cart->quantity;
					$order_detail->save();
					$cart->delete();
				}
				return redirect()->route('order.detail')->with('success', 'お買い上げ誠にありがとうございます。');
			} catch(Exception $e) {
				if ($charge_id !== null) {
					Refund::create(array(
						'charge' => $charge_id,
						'amount' => $total,
					));
				}
				return $e->getMessage();
			}
		}
		return redirect()->route('user.page')->with('error', '既にお買い上げ済みです');
	}

	public function address() {
		$cart = Cart::where('user_id', Auth::id())->first();
		if ($cart) {
			$addresses = Address::where('user_id', Auth::id())->get();
			$prefectures = config('prefecture');
			return view('payment.address', compact('addresses', 'prefectures'));
		} else {
			return redirect()->route('user.page');
		}
	}

	public function detail() {
		$items = DB::table('items')
			->join('order_details', 'order_details.item_id', '=', 'items.id')
			->join('orders', function ($join) {
				$join->on('order_details.order_id', '=', 'orders.id')
					->where('orders.user_id', '=', Auth::id())
					->whereNull('order_details.deleted_at');
			})
			->get();
		$reviews = Review::where('user_id', Auth::id())->get();
		$total = Payment::where('user_id', Auth::id())->sum(DB::raw('price'));
		$exist = array_filter((array)$items);
		return view('payment.detail', compact('items', 'exist', 'expire', 'subtotal', 'total', 'reviews'));
	}

	public function cancel(Request $request) {
		$order = DB::table('order_details')
			->where('order_id', $request->order_id)
			->where('item_id', $request->item_id)
			->where('deliver_status', 0)
			->join('orders', function ($join) {
				$join->on('orders.id', '=', 'order_details.order_id')
					->where('orders.user_id', Auth::id());
			})
			->first();
		if ($order) {
			if ($order->quantity < $request->quantity) {
				return redirect()->route('order.detail')->with('error', '注文した数より多いです');
			} elseif ($request->quantity <= 0) {
				return redirect()->route('order.detail')->with('error', '1以上の数字を入力してください');
			} else {
				$order_detail = Order_detail::where('order_id', $order->order_id)->where('item_id', $order->item_id)->first();
				$payment = Payment::where('id', $order->payment_id)->first();
				$item = Item::where('id', $order->item_id)->first();
				$total = floor($item->price * $request->quantity * 1.1);
				Stripe::setApiKey(config('stripe.STRIPE_SECRET'));
				$refund = Refund::create([
					'charge' => $payment->stripe_id,
					'amount' => $total,
				]);
				DB::transaction(function() use ($order_detail, $request, $item, $payment, $total, $order) {
					$item->stock = $item->stock + $request->quantity;
					$item->save();
					$price = $payment->price - $total;
					$payment = Payment::where('id', $order->payment_id)->update(['price' => $price]);
					Order_detail::where('id', $order_detail->id)->update(['deliver_status' => 2]);
					Order_detail::find($order_detail->id)->delete();
				});
				$order_detail_id = Order_detail::where('order_id', $order->order_id)->first();
				if (!$order_detail_id) {
					Payment::find($order->payment_id)->delete();
					Order::find($order->order_id)->delete();
				}
				return redirect()->route('order.detail')->with('success', 'キャンセルしました');
			}
		} else {
			return back()->with('error', '返品できませんでした。');
		}
	}
}
