<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFreeMail extends Mailable {
    use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	protected $content;

	public function __construct($contact) {
		$this->contact = $contact;
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
		->view('mail.contactUserTemp')
		->with(['contact' => $this->contact]);
	}
}
