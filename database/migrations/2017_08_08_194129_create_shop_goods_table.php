<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_goods', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键');
			$table->integer('store_id')->default(0)->comment('商家ID');
			$table->string('store_name', 11)->nullable()->comment('商家名称');
			$table->decimal('price', 20)->nullable()->comment('销售价格');
			$table->integer('sku_id')->nullable()->comment('最低价对应的SKU');
			$table->decimal('max_price', 20)->nullable()->comment('最高价格');
			$table->string('name', 50)->comment('商品名称');
			$table->string('cover_path', 502)->nullable()->comment('商品封面');
			$table->integer('brand_id')->default(0)->comment('品牌ID');
			$table->string('tags')->nullable()->default('')->comment('标签名称，多个以英文逗号分隔');
			$table->integer('cate_id')->default(0)->index('idx_commodity_category')->comment('商品分类');
			$table->string('description')->default('')->comment('商品描述');
			$table->text('content', 65535)->nullable()->comment('商品详情');
			$table->integer('hot')->default(0)->comment('热卖');
			$table->integer('sort')->default(0)->index('idx_commodity_sort')->comment('排序');
			$table->boolean('status')->nullable()->default(0)->comment('商品状态 1在售 0下架');
			$table->char('unit', 20)->default('')->comment('单位');
			$table->integer('begin_num')->default(1)->comment('起订量');
			$table->boolean('verify')->nullable()->default(1)->comment('商品审核 0未通过 ,1通过，10审核中');
			$table->timestamps();
			$table->softDeletes()->index('idx_deleted_at')->comment('删除时间');
			$table->index(['hot','name'], 'idx_name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_goods');
	}

}
