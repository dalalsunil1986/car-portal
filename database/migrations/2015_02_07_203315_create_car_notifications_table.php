<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('makes')->nullable();
            $table->string('brands')->nullable();
            $table->string('types')->nullable();
            $table->string('models')->nullable();
            $table->integer('year_from')->nullable();
            $table->string('year_to')->nullable();
            $table->string('mileage_from')->nullable();
            $table->string('mileage_to')->nullable();
            $table->string('price_from')->nullable();
            $table->string('price_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('car_notifications');
    }

}
