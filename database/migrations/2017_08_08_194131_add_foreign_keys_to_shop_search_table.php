<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_search', function(Blueprint $table)
		{
			$table->foreign('cate_id', 'cate_id_foreign')->references('id')->on('shop_category')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_search', function(Blueprint $table)
		{
			$table->dropForeign('cate_id_foreign');
		});
	}

}
