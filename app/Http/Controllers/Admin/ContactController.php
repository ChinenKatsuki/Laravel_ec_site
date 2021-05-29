<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Models\Item;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContactController extends Controller {

	public function index() {
		$contacts = Contact::orderBy('created_at', 'desc')->get();
		return view('contact.admin.contact_index', compact('contacts'));
	}

	public function detail($id) {
		$contact = Contact::find($id);
		if ($contact) {
			$item = DB::table('contacts')
			->where('contacts.id', $contact->id)
			->join('order_details', 'contacts.order_detail_id', '=', 'order_details.id')
			->join('items', 'order_details.item_id', '=', 'items.id')
			->first();
			return view('contact.admin.contact_detail', compact('contact', 'item'));
		} else {
			return redirect()->route('admin.contact.index')->with('error', 'お問い合わせ情報が存在しません');
		}
	}
}
