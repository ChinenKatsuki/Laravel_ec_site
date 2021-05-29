<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('subscriptions', function (Blueprint $table) {
			$table->increments('id');
			//ユーザーIDを保存
			$table->integer('user_id');
			//課金後に、サブスクリプションの状況などを取得するときに使用
			$table->string('name');
			//StripeのサブスクリプションIDを保存
			$table->string('stripe_id');
			//StripeのプランIDもしくは料金IDを保存
			$table->string('stripe_plan');
			//サブスクリプションの数量を保存
			$table->integer('quantity');
			//使用期間の終了日時
			$table->timestamp('trial_ends_at')->nullable();
			//課金の終了日時を保存
			$table->timestamp('ends_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('subscriptions');
	}
}
