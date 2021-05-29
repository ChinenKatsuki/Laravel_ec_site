<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class ItemAddRequest extends FormRequest {
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
	public function rules() {
		return [
			'name' => 'required|unique:items',
			'explain' => 'required',
			'price' => 'required|integer|min:1|max:10000000',
			'stock' => 'required|integer|min:0|max:10000',
			'image' => 'file|image|mimes:jpeg,png,jpg|max:4000',
		];
	}
}
