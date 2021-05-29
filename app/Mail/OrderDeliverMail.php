<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDeliverMail extends Mailable {
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	//protected $user;
	protected $item, $user;
	public function __construct($user, $item) {
		$this->user = $user;
		$this->item = $item;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this
		->from('hoge@hoge.com')
		->subject('商品発送のお知らせ')
		->view('mail.orderDeliverMailTemp')
		->with(['user' => $this->user, 'item' => $this->item]);
	}
}
