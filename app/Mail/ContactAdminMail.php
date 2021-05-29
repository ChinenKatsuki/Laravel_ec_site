<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactAdminMail extends Mailable {
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	protected $content, $user;

	public function __construct($contact, $user) {
		$this->contact = $contact;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this
		->from('hoge@hoge.com')
		->subject('お問い合わせ')
		->view('mail.contactAdminTemp')
		->with(['user' => $this->user, 'contact' => $this->contact]);
	}
}
