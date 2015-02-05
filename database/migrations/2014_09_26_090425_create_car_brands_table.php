<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCarBrandsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_brands', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('make_id');
            $table->string('name_en',30)->nullable();
            $table->string('name_ar',30)->nullable();
            $table->string('slug',30)->nullable();
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
        Schema::drop('car_brands');
    }

}
