<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_category', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('索引ID');
			$table->char('name', 50)->comment('分类名称');
			$table->integer('pid')->default(0)->comment('父ID');
			$table->char('tree', 60)->default('')->comment('该分类的家族关系');
			$table->boolean('sort')->default(0)->comment('排序');
			$table->string('title', 32)->default('');
			$table->string('keyword')->default('');
			$table->char('cate_dir', 30)->default('')->unique('cate_dir_unique')->comment('分类目录(用于URL)');
			$table->integer('root_id')->nullable()->comment('更目录');
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
		Schema::drop('shop_category');
	}

}
