<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDeliverStatusOrderDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('order_details', function (Blueprint $table) {
			$table->integer('deliver_status')->default(0)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('order_details', function (Blueprint $table) {
			$table->string('deliver_status', 20)->after('quantity');
		});
	}
}
