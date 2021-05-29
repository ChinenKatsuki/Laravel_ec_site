<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('addresses', function (Blueprint $table) {
			$table->increments('id');
			//Auth::id()格納
			$table->integer('user_id');
			//氏名(性)
			$table->string('family_name', 20);
			//氏名(名)
			$table->string('last_name', 20);
			//郵便番号
			$table->integer('prefecture_code');
			//都道府県
			$table->string('prefecture', 10);
			//市町村
			$table->string('city', 50);
			//それ以下の住所
			$table->string('address', 50);
			//電話番号
			$table->integer('phone_number');
			//住所の登録は0
			//届け先は1
			//で住所を管理
			$table->tinyInteger('deliver_flag')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('addresses');
	}
}
