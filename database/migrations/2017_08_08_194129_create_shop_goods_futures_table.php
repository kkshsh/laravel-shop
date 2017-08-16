<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsFuturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods_futures', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键ID');
			$table->integer('cate_id')->comment('商品分类');
			$table->string('name', 50)->index('idx_name')->comment('商品名称');
			$table->string('tags')->nullable()->default('')->comment('商品关键词');
			$table->integer('brand_id')->default(0)->comment('品牌ID');
			$table->integer('origin_id')->default(0)->comment('产地');
			$table->integer('port_id')->default(0)->comment('到货港口');
			$table->string('level', 32)->default('')->comment('等级');
			$table->decimal('days', 11, 1)->default(0.0)->comment('货运时间');
			$table->string('spec', 32)->default('')->comment('规格');
			$table->decimal('amount', 11)->default(0.00)->comment('金额');
			$table->boolean('on_sale')->default(0)->comment('售卖中（上下架）');
			$table->integer('min_num')->unsigned()->default(0)->comment('起订量');
			$table->integer('max_num')->unsigned()->default(0)->comment('可定总量');
			$table->boolean('deposit')->default(0)->comment('可定总量');
			$table->text('brand_desc', 65535)->nullable()->comment('品牌介绍');
			$table->text('product_desc', 65535)->nullable()->comment('产品介绍');
			$table->timestamps();
			$table->softDeletes()->index('idx_deleted_at')->comment('删除时间');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_goods_futures');
	}

}
