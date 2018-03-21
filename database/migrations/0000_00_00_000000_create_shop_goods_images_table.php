<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods_images', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('goods_id')->index('foreign_g_i_goods_id')->comment('商品ID');
			$table->string('path', 512)->comment('图片地址');
			$table->string('desc', 512)->nullable()->comment('图片描述');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_goods_images');
	}

}
