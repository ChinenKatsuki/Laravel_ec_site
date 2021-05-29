<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressUpdateRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(Request $request) {
		return [
			'family_name' => 'required|max:20',
			'last_name' => 'required|max:20',
			'prefecture_code' => [
				'regex:/^[0-9]{7}$/', Rule::unique('addresses')->ignore($request->id)->where(function ($query) {
					return $query->where('prefecture_code', $this->input('prefecture_code'))
					->where('city', $this->input('city'))
					->where('address', $this->input('address'))
					->where('user_id', Auth::id())
					->whereNull('deleted_at');
				}),
			],
			'city' => 'required',
			'address' => 'required',
			'prefecture_name' => 'required',
			'phone_number' => 'regex:/^[0-9]{10,11}$/'
		];
	}

	public function messages() {
		return [
			'prefecture_code.regex' => '郵便番号はﾊｲﾌﾝなしで7桁の数字を入力してください。',
			'phone_number.regex' => '電話番号は10桁、もしくは11桁の数字を入力してください。',
			'prefecture_code.unique' => 'こちらの住所は既に登録されています',
		];
	}
}
