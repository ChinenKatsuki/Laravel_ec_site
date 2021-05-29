<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;
//use Laravel\Cashier\Billable;


class User extends Authenticatable {
	use Notifiable;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token) {
		$this->notify(new PasswordReset($token));
	}
	public function routeNotificationForSlack() {
		return 'https://hooks.slack.com/services/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';
	}
}
