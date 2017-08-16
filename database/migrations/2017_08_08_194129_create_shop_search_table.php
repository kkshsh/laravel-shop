<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_search', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('主键');
			$table->string('name')->comment('搜索列名称');
			$table->string('value', 2048)->nullable()->comment('属性的值,用","隔开');
			$table->integer('cate_id')->comment('分类id');
			$table->smallInteger('sort')->unsigned()->default(0)->comment('排序');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
			$table->primary(['id','cate_id']);
			$table->unique(['cate_id','name'], 'cateid_name_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_search');
	}

}
