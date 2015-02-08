<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('notifications', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type')->index(); // JOB,CAR
			$table->integer('user_id')->unsigned()->index();
			$table->string('year_from')->nullable();
			$table->string('year_to')->nullable();
			$table->string('mileage_from')->nullable();
			$table->string('mileage_to')->nullable();
			$table->string('price_from')->nullable();
			$table->string('price_to')->nullable();
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
		//
		Schema::drop('notifications');
	}

}
