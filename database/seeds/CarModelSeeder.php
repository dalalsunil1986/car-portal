<?php

use App\Src\Car\CarBrand;
use App\Src\Car\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $chevrolet = CarBrand::where('name_en', 'LIKE', 'chevrolet')->first()->id;
        $bmw       = CarBrand::where('name_en', 'LIKE', 'bmw')->first()->id;
        $mercedes  = CarBrand::where('name_en', 'LIKE', 'mercedes')->first()->id;
        $audi      = CarBrand::where('name_en', 'LIKE', 'audi')->first()->id;
        $toyota    = CarBrand::where('name_en', 'LIKE', 'toyota')->first()->id;
        $ford      = CarBrand::where('name_en', 'LIKE', 'ford')->first()->id;
        $hyundai   = CarBrand::where('name_en', 'LIKE', 'hyundai')->first()->id;
        $nissan    = CarBrand::where('name_en', 'LIKE', 'nissan')->first()->id;
        $porsche   = CarBrand::where('name_en', 'LIKE', 'porsche')->first()->id;
        $honda     = CarBrand::where('name_en', 'LIKE', 'honda')->first()->id;

        $types = [1,2,3,4];

        CarModel::create([
            'name_en' => 'Corolla',
            'brand_id' => $toyota,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Cruze',
            'brand_id' => $chevrolet,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Altima',
            'brand_id' => $nissan,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Cayenne',
            'brand_id' => $porsche,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Camry',
            'brand_id' => $toyota,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Mustang',
            'brand_id' => $ford,
            'type_id'    => $faker->randomElement($types),
        ]);
        CarModel::create([
            'name_en' => 'Fortuner',
            'brand_id' => $toyota,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Sunny',
            'brand_id' => $nissan,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'CRV',
            'brand_id' => $honda,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'X5',
            'brand_id' => $bmw,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'S8',
            'brand_id' => $mercedes,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'A4',
            'brand_id' => $audi,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'A6',
            'brand_id' => $audi,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Aurion',
            'brand_id' => $toyota,
            'type_id'    => $faker->randomElement($types),
        ]);

        CarModel::create([
            'name_en' => 'Sonata',
            'brand_id' => $hyundai,
            'type_id'    => $faker->randomElement($types),
        ]);


    }
}