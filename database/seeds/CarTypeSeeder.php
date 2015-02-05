<?php

use App\Src\Car\CarType;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarType::create([
            'name_en' => 'SUV',
        ]);
        CarType::create([
            'name_en' => 'Coupe',
        ]);
        CarType::create([
            'name_en' => 'Sport',
        ]);
        CarType::create([
            'name_en' => 'Saloon',
        ]);

    }
}