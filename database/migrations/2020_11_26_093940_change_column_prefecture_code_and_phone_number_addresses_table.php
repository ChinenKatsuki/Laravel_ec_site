<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnPrefectureCodeAndPhoneNumberAddressesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('addresses', function (Blueprint $table) {
			$table->string('prefecture_code', 10)->change();
			$table->string('phone_number', 20)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('addresses', function (Blueprint $table) {
			$table->integer('prefecture_code')->change();
			$table->bigInteger('phone_number')->change();
		});
	}
}
