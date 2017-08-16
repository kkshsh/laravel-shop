<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopAttributeValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_attribute_value', function(Blueprint $table)
		{
			$table->foreign('attr_id', 'unique_attr_id')->references('id')->on('shop_attribute')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_attribute_value', function(Blueprint $table)
		{
			$table->dropForeign('unique_attr_id');
		});
	}

}
