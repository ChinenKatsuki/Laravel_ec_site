<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressIdToOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('orders', function (Blueprint $table) {
			//氏名(性)
			$table->string('family_name', 20)->after('payment_id');
			//氏名(名)
			$table->string('last_name', 20)->after('family_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('family_name');
			$table->dropColumn('last_name');
		});
	}
}
