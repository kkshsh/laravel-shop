<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopAttributeValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_attribute_value', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('属性编号');
			$table->string('name', 100)->comment('属性值名称');
			$table->integer('attr_id')->index('unique_attr_id')->comment('所属属性id');
			$table->integer('cate_id')->comment('所属类型id');
			$table->boolean('sort')->nullable()->comment('排序');
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['name','attr_id'], 'idx_attr_name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_attribute_value');
	}

}
