<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeColumnToUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			//Stripeの顧客IDの保存
			$table->string('stripe_id')->nullable();
			//カードブランドの保存
			$table->string('card_brand')->nullable();
			//支払い方法に使用するカードの下4桁の数字を保存
			$table->string('card_last_four, 4')->nullable();
			//使用期間の終了日時を保存
			$table->timestamp('trial_ends_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			//カラムの削除
			$table->dropColumn('stripe_id');
			$table->dropColumn('card_brand');
			$table->dropColumn('card_last_four, 4');
			$table->dropColumn('trial_ends_at');
		});
	}
}
