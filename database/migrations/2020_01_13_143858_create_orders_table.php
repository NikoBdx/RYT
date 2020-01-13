<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('tool_id')->unsigned();
			$table->bigInteger('driver_id')->unsigned();
			$table->string('status', 255);
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}