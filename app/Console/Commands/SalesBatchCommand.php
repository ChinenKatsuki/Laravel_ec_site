<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Item;
use App\User;

class SalesBatchCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'batch:sales';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '売り上げバッチ処理';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$user = new User;
		$user->notify(new \App\Notifications\SlackNotification());
		$this->line('Message sent');
	}
}
