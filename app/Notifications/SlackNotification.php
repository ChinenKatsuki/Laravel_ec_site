<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class SlackNotification extends Notification {
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return ['slack'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toSlack($notifiable) {
		$date = date('Y/m/d', strtotime('-1 day'));
		$sales = Payment::whereDate('created_at', $date)->sum(DB::raw('price'));
		return (new SlackMessage)
			->from('chinen')
			->to('スラック通知テスト')
			//->content($date . 'の売り上げは￥' . number_format($sales) . 'です');
			->content('test');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) {
		return [
			//
		];
	}
}
