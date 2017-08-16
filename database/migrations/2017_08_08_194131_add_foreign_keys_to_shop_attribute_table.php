<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_attribute', function(Blueprint $table)
		{
			$table->foreign('cate_id', 'unique_attr_cate_id')->references('id')->on('shop_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_attribute', function(Blueprint $table)
		{
			$table->dropForeign('unique_attr_cate_id');
		});
	}

}
