<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsCommendTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods_commend', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('goods_id')->comment('商品ID');
			$table->integer('commend_goods_id')->comment('推荐的商品');
			$table->boolean('type')->default(1)->comment('推荐的类型：1自动推荐，2人工推荐');
			$table->integer('weight')->default(1)->comment('权重');
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
		Schema::drop('shop_goods_commend');
	}

}
