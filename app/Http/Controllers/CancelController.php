<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
use Illuminate\Http\Request;

class CancelController extends Controller {

	public function cancel(Request $request) {
		$order = DB::table('order_details')
		->where('order_id', $request->order_id)
		->where('item_id', $request->item_id)
		->where('deliver_status', '発送準備中')
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
				DB::transaction(function() use ($order_detail, $request, $item) {
					$quantity = $order_detail->quantity - $request->quantity;
					Order_detail::where('id', $order_detail->id)->update(['quantity' => $quantity]);
					$item->stock = $item->stock + $request->quantity;
					$item->save();
				});
				$order_detail_quantity = Order_detail::where('order_id', $order->order_id)->where('item_id', $order->item_id)->first();
				if ($order_detail_quantity->quantity == 0) {
					Order_detail::where('id', $order_detail->id)->update(['deliver_status' => '返品']);
					Order_detail::find($order_detail->id)->delete();
					$order_detail_id = Order_detail::where('order_id', $order->order_id)->first();
					if (!$order_detail_id) {
						Payment::find($order->payment_id)->delete();
						Order::find($order->order_id)->delete();
					}
				}
				return redirect()->route('order.detail')->with('success', 'キャンセルしました');
			}
		} else {
			return back()->with('error', '返品できませんでした。');
		}
	}
}
