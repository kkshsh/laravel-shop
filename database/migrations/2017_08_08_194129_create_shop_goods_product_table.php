<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods_product', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键（商品ID ,SKU)');
			$table->integer('goods_id')->index('foreign_g_p_goods_id')->comment('商品SPU管理');
			$table->string('name', 100)->index('idx_name')->comment('商品名称');
			$table->string('sku_name', 100)->nullable()->comment('SKU名称');
			$table->decimal('price', 20)->default(0.00)->index('idx_price')->comment('销售价格');
			$table->decimal('market_price', 20)->default(0.00)->comment('市场价格');
			$table->decimal('cost_price', 20)->nullable()->default(0.00)->comment('成本价');
			$table->integer('weight')->default(0)->comment('重量');
			$table->integer('limit_purchase')->nullable()->comment('限购');
			$table->integer('stock')->default(0)->comment('商品库存');
			$table->integer('hot')->default(0)->comment('热度');
			$table->boolean('on_sale')->default(1)->comment('售卖中');
			$table->boolean('status')->default(0)->comment('商品状态 0下架，1正常');
			$table->text('spec', 65535)->nullable()->comment('商品规格(json)');
			$table->char('spec_md5', 32)->nullable()->index('idx_spec_md5')->comment('商品规格(md5)');
			$table->string('spec_str', 512)->nullable()->comment('商品规格');
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
		Schema::drop('shop_goods_product');
	}

}
