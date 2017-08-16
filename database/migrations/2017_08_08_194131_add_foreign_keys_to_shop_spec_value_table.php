<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopSpecValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_spec_value', function(Blueprint $table)
		{
			$table->foreign('spec_id', 'foreig_spec_id')->references('id')->on('shop_spec')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_spec_value', function(Blueprint $table)
		{
			$table->dropForeign('foreig_spec_id');
		});
	}

}
