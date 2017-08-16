<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopSpecTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_spec', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('属性编号');
			$table->string('name', 100)->comment('属性名称');
			$table->text('value', 65535)->comment('属性值列');
			$table->integer('cate_id')->index('index_cate_id')->comment('所属分类id');
			$table->boolean('sort')->nullable()->comment('排序');
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['cate_id','name'], 'unique_spec_cate_id_name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_spec');
	}

}
