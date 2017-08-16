<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopBrandTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_brand', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键');
			$table->string('name', 32)->comment('品牌名');
			$table->string('logo')->comment('品牌LOGO');
			$table->string('description')->comment('品牌介绍');
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
		Schema::drop('shop_brand');
	}

}
