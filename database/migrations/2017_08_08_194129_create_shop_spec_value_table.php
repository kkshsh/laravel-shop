<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopSpecValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_spec_value', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('规格值id');
			$table->string('name', 100)->comment('规格值名称');
			$table->integer('cate_id')->comment('所属分类id');
			$table->integer('spec_id')->nullable()->index('idx_')->comment('规格ID');
			$table->boolean('sort')->nullable()->comment('排序');
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
		Schema::drop('shop_spec_value');
	}

}
