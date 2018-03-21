<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShopGoodsImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_goods_images', function(Blueprint $table)
		{
			$table->foreign('goods_id', 'foreign_g_i_goods_id')->references('id')->on('shop_goods')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shop_goods_images', function(Blueprint $table)
		{
			$table->dropForeign('foreign_g_i_goods_id');
		});
	}

}
