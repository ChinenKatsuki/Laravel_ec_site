<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ItemUpdateRequest extends FormRequest {
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
	public function rules(request $request) {
		return [
			'name' => ['required', Rule::unique('items')->ignore($request->id)],
			'explain' => 'required',
			'stock' => 'required|integer|min:0|max:10000',
			'image' => 'file|image|mimes:jpeg,png,jpg|max:4000',
		];
	}
}
