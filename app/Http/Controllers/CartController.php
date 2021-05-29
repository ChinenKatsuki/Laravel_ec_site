<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use App\Address;
use App\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {

	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}

	public function index() {
		$carts = Cart::where('user_id', Auth::id())->get();
		$subtotal = Cart::where('user_id', Auth::id())->sum(DB::raw('price * quantity'));
		$total = floor($subtotal * 1.1);
		$address = Address::where('user_id', Auth::id())->first();
		return view('cart.index', compact('carts', 'subtotal', 'total', 'address'));
	}

	public function add($id) {
		$item = Item::find($id);
		if ($item && ($item->stock != 0)) {
			$item_id = Cart::where('item_id', $id)->where('user_id', Auth::id())->value('item_id');
			if ($item_id) {
				DB::transaction(function() use ($id, $item_id) {
					$quantity = Cart::where('item_id', $item_id)->where('user_id', Auth::id())->value('quantity');
					$sum = $quantity + 1;
					Cart::where('item_id', $item_id)->update(['quantity' => $sum]);
					$stock = Item::where('id', $id)->value('stock');
					$sum = $stock - 1;
					Item::where('id', $id)->update(['stock' => $sum]);
				});
			} else {
				DB::transaction(function() use ($id, $item) {
					$cart = new Cart;
					$cart->item_id = $id;
					$cart->user_id = Auth::id();
					$cart->name = $item->name;
					$cart->price = $item->price;
					$cart->quantity = 1;
					$cart->save();
					$stock = Item::where('id', $id)->value('stock');
					$sum = $stock - 1;
					Item::where('id', $id)->update(['stock' => $sum]);
				});
			}
			return redirect()->route('user.page')->with('message', '商品をカートに追加しました');
		} else {
			return redirect()->route('user.page')->with('message', '商品が存在しません');
		}
	}

	public function delete(Request $request) {
		$item_id = Cart::where('id', $request->id)->where('user_id', Auth::id())->value('item_id');
		if ($item_id) {
			$cart = Cart::find($request->id);
			$quantity = Cart::where('id', $request->id)->where('user_id', Auth::id())->value('quantity');
			DB::transaction(function() use ($cart, $item_id, $quantity) {
				$cart->delete();
				$stock = Item::where('id', $item_id)->value('stock');
				$sum = $stock + $quantity;
				Item::where('id', $item_id)->update(['stock' => $sum]);
			});
			return redirect()->route('cart.index');
		} else {
			return redirect()->route('cart.index')->with('message', '削除できませんでした');
		}
	}

	public function confirm() {
		$carts = Cart::where('user_id', Auth::id())->get();
		$exist = array_filter((array)$carts);
		if ($exist) {
			$subtotal = Cart::where('user_id', Auth::id())->sum(DB::raw('price * quantity'));
			$total = floor($subtotal * 1.1);
			$address = Address::where('user_id', Auth::id())->where('deliver_flag', 1)->first();
			if (!$address) {
				return back()->with('error', 'お届け先住所を選択して下さい');
			}
			return view('cart.confirm', compact('carts', 'subtotal', 'total', 'address'));
		} else {
			return redirect()->route('user.page');
		}
	}
}

