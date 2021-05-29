<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Order_detail;
use App\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddReviewRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReviewController extends Controller {

	public function create($id) {
		$review = DB::table('orders')
			->join('order_details', 'orders.id', '=', 'order_details.order_id')
			->where('order_details.item_id', $id)
			->where('orders.user_id', Auth::id())
			->where('order_details.deliver_status', 1)
			->where('order_details.review_id', null)
			->whereNull('order_details.deleted_at')
			->first();
		if ($review) {
			$item = Item::where('id', $id)->first();
			return view('review.create', compact('item'));
		} else {
			return back()->with('error', '商品情報が見つかりませんでした');
		}
	}

	public function send(AddReviewRequest $request) {
		$review = DB::table('orders')
			->join('order_details', 'orders.id', '=', 'order_details.order_id')
			->where('order_details.item_id', $request->item_id)
			->where('orders.user_id', Auth::id())
			->where('order_details.deliver_status', 1)
			->where('order_details.review_id', null)
			->whereNull('order_details.deleted_at')
			->first();
		if ($review) {
			$review = new Review;
			$review->user_id = Auth::id();
			$review->item_id = $request->item_id;
			$review->score = $request->score;
			$review->comment = $request->comment;
			$review->save();
			$review = Review::where('user_id', Auth::id())->where('item_id', $request->item_id)->first();
			$items = DB::table('orders')
				->join('order_details', 'orders.id', '=', 'order_details.order_id')
				->where('order_details.item_id', $request->item_id)
				->where('orders.user_id', Auth::id())
				->where('order_details.deliver_status', 1)
				->where('order_details.review_id', null)
				->whereNull('order_details.deleted_at')
				->get();
			foreach ($items as $item) {
				Order_detail::where('id', $item->id)->update(['review_id' => $review->id]);
			}
			return redirect()->route('user.page')->with('success', 'レビューしました');
		} else {
			return back()->with('error', 'レビューできませんでした');
		}
	}
}
