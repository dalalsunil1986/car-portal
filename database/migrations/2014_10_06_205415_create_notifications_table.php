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
			$table->integer('year_from')->nullable();
			$table->integer('year_to')->nullable();
			$table->integer('mileage_from')->nullable();
			$table->integer('mileage_to')->nullable();
			$table->decimal('price_from',9,2)->nullable();
            $table->decimal('price_to',9,2)->nullable();
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
