<?php
namespace App\Http\Controllers\Admin;
use App\User;
use App\Models\Cart;
use App\Address;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Item;
use App\Models\Addresses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\OrderDeliverMail;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

class UserDetailController extends Controller {

	public function index() {
		$users = User::all();
		return view('admin.users_detail.index', compact('users'));
	}

	public function order(Request $request) {
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$user_name = $request->user_name;

		$query = DB::table('payments')
			->join('orders', 'orders.payment_id', '=', 'payments.id')
			->orderBy('orders.id','desc')
			->whereNull('orders.deleted_at');

		if (isset($start_date) && (isset($end_date))) {
			if ($start_date > $end_date) {
				return redirect()->route('admin.user.order')->with('error', '終了日時は開始日時より後にして下さい');
			}
		}

		if ($request->has('start_date') && $start_date != '') {
			$query->where('orders.created_at', '>=', $start_date)
			->get();
		}

		if ($request->has('end_date') && $end_date != '') {
			$query->where('orders.created_at', '<', date("Y-m-d", strtotime('+1 day' . $end_date)))
			->get();
		}

		if ($request->has('user_name') && $user_name != '') {
			$query->where(function ($query) use ($user_name) {
				$query->where('orders.family_name', 'like', '%' . $user_name . '%')
					->orwhere('orders.last_name', 'like', '%' . $user_name . '%');
			})
			->get();
		}
		$order_serches = $query->paginate(10);

		if ($order_serches->isEmpty()) {
			return redirect()->route('admin.user.order')->with('error', 'ヒットしませんでした');
		}

		return view('admin.users_detail.order', compact('order_serches', 'start_date', 'end_date', 'user_name'));
	}

	public function detail($id) {
		$user = User::find($id);
		if ($user) {
			$addresses = Address::where('user_id', $id)->get();
			return view('admin.users_detail.detail', compact('user', 'addresses'));
		} else {
			return redirect()->route('admin.user.index')->with('error', 'ユーザー情報が存在しません');
		}
	}

	public function orderDetail($id) {
		$details = DB::table('items')
			->join('order_details', 'order_details.item_id', '=', 'items.id')
			->join('orders', 'orders.id', '=', 'order_details.order_id')
			->where('orders.id', '=', $id)
			->get();
		$exist = array_filter((array)$details);
		if ($exist) {
			$total = DB::table('orders')
				->where('orders.id', '=', $id)
				->join('payments', 'orders.payment_id', '=', 'payments.id')
				->first();
			return view('admin.users_detail.order_detail', compact('details', 'total'));
		} else {
			return back();
		}
	}

	public function deliverStatus(Request $request, $id) {
		$update = DB::table('order_details')
		->where('order_details.order_id', '=', $request->order_id)
		->where('order_details.item_id', '=', $request->item_id)
		->whereNull('order_details.deleted_at')
		->join('orders', function ($join) use ($id) {
			$join->on('order_details.order_id', '=', 'orders.id')
			->where('orders.user_id', '=', $id);
		})
		->update(['deliver_status' => 1]);
		if ($update) {
			$confirm = DB::table('order_details')
				->where('order_details.item_id', '=', $request->item_id)
				->where('order_details.deliver_status', '=', 1)
				->whereNull('order_details.deleted_at')
				->join('orders', function ($join) use ($id) {
					$join->on('order_details.order_id', '=', 'orders.id')
						->where('orders.user_id', '=', $id);
				})
				->select('order_details.review_id')
				->first();
			if ($confirm->review_id != null) {
				$update = DB::table('order_details')
					->where('order_details.order_id', '=', $request->order_id)
					->where('order_details.item_id', '=', $request->item_id)
					->whereNull('order_details.deleted_at')
					->join('orders', function ($join) use ($id) {
						$join->on('order_details.order_id', '=', 'orders.id')
							->where('orders.user_id', '=', $id);
					})
					->update(['review_id' => $confirm->review_id]);
			}
			$user = User::find($id);
			$item = DB::table('items')
				->join('order_details', 'order_details.item_id', '=', 'items.id')
				->where('order_details.item_id', '=', $request->item_id)
				->where('order_details.order_id', '=', $request->order_id)
				->first();
			Mail::to($user->email)
				->send(new OrderDeliverMail($user, $item));
		}
		return back();
	}

	public function csvExport(Request $request) {
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$user_name = $request->user_name;

		$query = DB::table('payments')
			->join('orders', 'orders.payment_id', '=', 'payments.id')
			->orderBy('orders.id','desc')
			->whereNull('orders.deleted_at');

		if (isset($start_date) && (isset($end_date))) {
			if ($start_date > $end_date) {
				return redirect()->route('admin.user.order')->with('error', 'csv出力できませんでした');
			}
		}

		if ($request->has('start_date') && $start_date != '') {
			$query->where('orders.created_at', '>=', $start_date)
			->get();
		}

		if ($request->has('end_date') && $end_date != '') {
			$query->where('orders.created_at', '<', date("Y-m-d", strtotime('+1 day' . $end_date)))
			->get();
		}

		if ($request->has('user_name') && $user_name != '') {
			$query->where(function ($query) use ($user_name) {
				$query->where('orders.family_name', 'like', '%' . $user_name . '%')
					->orwhere('orders.last_name', 'like', '%' . $user_name . '%');
			})
			->get();
		}
		$order_serches = $query->paginate(10);
		if ($order_serches->isEmpty()) {
			return redirect()->route('admin.user.order')->with('error', 'csv出力できませんでした');
		}

		$title = ['注文日', '性', '名', '郵便番号', '都道府県', '市町村', '番地'];
		$response = new StreamedResponse (function() use ($order_serches, $title){
			$stream = fopen('php://output', 'w');
			stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
			fputcsv($stream, $title);
			foreach ($order_serches as $order_serch) {
				$csv = [
					$order_serch->created_at,
					$order_serch->family_name,
					$order_serch->last_name,
					$order_serch->prefecture_code,
					$order_serch->prefecture_name,
					$order_serch->city,
					$order_serch->address
				];
				fputcsv($stream, $csv);
			}
			fclose($stream);
		});
		$response->headers->set('Content-Type', 'application/octet-stream');
		$response->headers->set('Content-Disposition', 'attachment; filename="order_history.csv"');
		return $response;
	}
}
