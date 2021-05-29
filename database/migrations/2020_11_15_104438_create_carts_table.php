<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function (Blueprint $table) {
			$table->increments('id');
			//カートに商品を入れたユーザーidを取得
			$table->integer('user_id');
			//itemのid
			$table->integer('item_id');
			//商品名
			$table->string('name', 50);
			//商品の価格
			$table->unsignedMediumInteger('price');
			//商品の個数
			$table->integer('quantity');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('carts');
	}
}
