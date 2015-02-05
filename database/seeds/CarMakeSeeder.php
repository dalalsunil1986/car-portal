<?php

use App\Src\Car\CarMake;
use Illuminate\Database\Seeder;

class CarMakeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarMake::create([
            'name_en' => 'American'
        ]);

        CarMake::create([
            'name_en' => 'Japanese'
        ]);

        CarMake::create([
            'name_en' => 'European'
        ]);
    }


}