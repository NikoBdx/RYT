<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToolsTable extends Migration {

	public function up()
	{
		Schema::create('tools', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('user_id')->unsigned();
			$table->string('title', 255);
			$table->text('description');
			$table->integer('price');
			$table->string('image');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tools');
	}
}