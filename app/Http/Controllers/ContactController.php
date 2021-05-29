<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Item;
use App\Contact;
use App\Models\Cart;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Mail\ContactAdminMail;
use App\Mail\ContactOrderAdminMail;
use App\Mail\ContactFreeMail;
use App\Mail\ContactAdminFreeMail;
use App\Mail\ContactOrderMail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactSendMailRequest;
use App\Http\Requests\ContactFreeSendMailRequest;
use Illuminate\Http\Request;

class ContactController extends Controller {

	public function createFree() {
		return view('contact.create_free');
	}

	public function freeSend(ContactFreeSendMailRequest $request) {
		$admin = Admin::first();
		$contact = new Contact;
		$contact->order_detail_id = 0;
		$contact->email = $request->email;
		$contact->title = $request->title;
		$contact->content = $request->content;
		$contact->save();
		Mail::to($admin->email)
		->send(new ContactFreeMail($contact));
		Mail::to($request->email)
		->send(new ContactAdminFreeMail($contact));
		return redirect()->route('user.page')->with('success', 'メールを送信しました');
	}

	public function create() {
		$items = DB::table('items')
		->join('order_details', 'order_details.item_id', '=', 'items.id')
		->join('orders', function ($join) {
			$join->on('order_details.order_id', '=', 'orders.id')
			->where('orders.user_id', '=', Auth::id())
			->whereNull('order_details.deleted_at');
		})
		->select('order_details.id', 'items.name', 'orders.created_at')
		->get();
		return view('contact.create', compact('items'));
	}

	public function send(ContactSendMailRequest $request) {
		$item = DB::table('orders')
		->join('order_details', 'orders.id', '=', 'order_details.order_id')
		->where('orders.user_id', '=', Auth::id())
		->where('order_details.id', '=', $request->order_detail_id)
		->whereNull('order_details.deleted_at')
		->first();
		$admin = Admin::first();
		$contact = $request->all();
		$user = Auth::user();
		if ($item || $request->order_detail_id == 0) {
			$contact = new Contact;
			$contact->user_id = Auth::id();
			$contact->order_detail_id = $request->order_detail_id;
			$contact->title = $request->title;
			$contact->content = $request->content;
			$contact->save();
			Mail::to(Auth::user()->email)
			->send(new ContactMail($contact, $user));
			Mail::to($admin->email)
			->send(new ContactAdminMail($contact, $user));
			return redirect()->route('user.page')->with('success', 'メールを送信しました');
		} else {
			return redirect()->route('user.page')->with('error', 'メールを送信できませんでした');
		}
	}
}
