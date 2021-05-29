<?php

namespace App\Http\Controllers\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressAddRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller {

	public function index() {
		$addresses = Address::where('user_id', Auth::id())->get();
		return view('address.index', compact('addresses'));
	}

	public function create() {
		$prefectures = config('prefecture');
		return view('address.create', compact('prefectures'));
	}

	public function add(AddressAddRequest $request) {
		$address = new Address;
		$address->user_id = Auth::id();
		$address->family_name = $request->family_name;
		$address->last_name = $request->last_name;
		$address->prefecture_code = $request->prefecture_code;
		$address->prefecture_name = $request->prefecture_name;
		$address->city = $request->city;
		$address->address = $request->address;
		$address->phone_number = $request->phone_number;
		$address->save();
		return back()->with('success', '住所を追加しました');
	}

	public function edit($id) {
		$address = Address::find($id);
		$prefectures = config('prefecture');
		if ($address && $address->user_id == Auth::id()) {
			return view('address.update', compact('address', 'prefectures'));
		} else {
			return redirect()->route('address.index')->with('error', '編集できませんでした');
		}
	}

	public function update(AddressUpdateRequest $request) {
		$address = address::find($request->id);
		if ($address && $address->user_id == Auth::id()) {
			$address->family_name = $request->family_name;
			$address->last_name = $request->last_name;
			$address->prefecture_code = $request->prefecture_code;
			$address->prefecture_name= $request->prefecture_name;
			$address->city = $request->city;
			$address->address = $request->address;
			$address->phone_number = $request->phone_number;
			$address->save();
			return redirect()->route('address.index')->with('success', '編集しました');
		} else {
			return redirect()->route('address.index')->with('error', '編集できませんでした');
		}
	}

	public function delete($id) {
		$address = address::find($id);
		if ($address && $address->user_id == Auth::id()) {
			$address->delete();
			return redirect()->route('address.index')->with('success', '削除しました');
		} else {
			return redirect()->route('address.index')->with('error', '削除できませんでした');
		}
	}

	public function deliver($id) {
		$address = Address::find($id);
		if ($address) {
			$deliver = Address::where('user_id', Auth::id())->where('id', $id)->first();
			$deliver_confirm = Address::where('user_id', Auth::id())->where('deliver_flag', 1)->first();
			if ($deliver->deliver_flag == 0) {
				$address->deliver_flag = 1;
				$address->save();
				if ($deliver_confirm) {
					$deliver_confirm->deliver_flag = 0;
					$deliver_confirm->save();
				}
				return back();
			} else {
				return redirect()->route('address.index')->with('error', '住所が登録されていません');
			}
		}
	}
}
