<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNamePrefectureAddressesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('addresses', function (Blueprint $table) {
			$table->renameColumn('prefecture', 'prefecture_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('addresses', function (Blueprint $table) {
			$table->renameColumn('prefecture_name', 'prefecture');
        });
    }
}
