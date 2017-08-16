<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopCategoryBrandTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_category_brand', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键');
			$table->integer('cate_id')->comment('类目主键');
			$table->integer('brand_id')->comment('品牌主键');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
			$table->unique(['cate_id','brand_id'], 'unique_cate_brand');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_category_brand');
	}

}
