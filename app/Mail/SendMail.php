<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\Models\EmailChange;

class SendMail extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
	public function build(Request $request) {
		$token = str_random(40);
		$email = $request->email;
		$email_change = new EmailChange;
		$email_change->email = $email;
		$email_change->token = $token;
		$email_change->save();
		return $this->view('mail.temp', compact('email', 'token'))
		->from('sss.khy1221@gmail.com', 'test')
		->subject('メールアドレスの変更');
	}
}
