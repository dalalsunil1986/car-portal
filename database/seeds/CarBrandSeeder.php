<?php

use App\Src\Car\CarBrand;
use Illuminate\Database\Seeder;

class CarBrandSeeder extends Seeder {

    const AMERICAN = 1;
    const JAPANESE = 2;
    const EUROPEAN = 3;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarBrand::create([
            'name_en' => 'Toyota',
            'make_id' => self::JAPANESE,
        ]);

        CarBrand::create([
            'name_en' => 'BMW',
            'make_id' => self::EUROPEAN,
        ]);

        CarBrand::create([
            'name_en' => 'Mercedes',
            'make_id' => self::EUROPEAN,
        ]);

        CarBrand::create([
            'name_en' => 'Chevrolet',
            'make_id' => self::AMERICAN,
        ]);

        CarBrand::create([
            'name_en' => 'Honda',
            'make_id' => self::JAPANESE,
        ]);

        CarBrand::create([
            'name_en' => 'Audi',
            'make_id' => self::EUROPEAN,
        ]);

        CarBrand::create([
            'name_en' => 'Ford',
            'make_id' => self::AMERICAN,
        ]);

        CarBrand::create([
            'name_en' => 'Hyundai',
            'make_id' => self::JAPANESE,
        ]);

        CarBrand::create([
            'name_en' => 'Mitsubishi',
            'make_id' => self::JAPANESE,
        ]);

        CarBrand::create([
            'name_en' => 'Nissan',
            'make_id' => self::JAPANESE,
        ]);
        CarBrand::create([
            'name_en' => 'Porsche',
            'make_id' => self::EUROPEAN,
        ]);

    }
}