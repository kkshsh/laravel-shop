<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopSpecTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_spec', function(Blueprint $table)
		{
			$table->foreign('cate_id', 'unique_spec_cate_id')->references('id')->on('shop_category')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_spec', function(Blueprint $table)
		{
			$table->dropForeign('unique_spec_cate_id');
		});
	}

}
