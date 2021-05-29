<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model {
	use softDeletes;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'item_id', 'quantity'];
	protected $table = 'carts';

	public function all_get($auth_id) {
		$carts = $this->where('user_id', $auth_id)->get();
		return $carts;
	}

	public function item() {
		return $this->belongsTo(Cart::class);
	}

	public function subtotal() {
		$result = $this->quantity * $this->price;
		return $result;
	}
}

