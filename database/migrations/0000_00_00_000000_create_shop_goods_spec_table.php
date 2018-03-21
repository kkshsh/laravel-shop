<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsSpecTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods_spec', function(Blueprint $table)
		{
			$table->increments('id')->comment('编号');
			$table->integer('goods_id')->index('foreign_g_s_goods_id')->comment('商品ID');
			$table->integer('cate_id')->nullable()->comment('分类ID');
			$table->integer('spec_id')->comment('属性ID');
			$table->char('spec_value_id', 32)->nullable()->comment('属性值ID');
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
		Schema::drop('shop_goods_spec');
	}

}
