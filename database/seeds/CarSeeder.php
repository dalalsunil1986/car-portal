<?php

use App\Src\Car\Car;
use App\Src\Car\CarModel;
use App\Src\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $model = CarModel::orderBY(DB::raw('RAND()'))->first()->id;
        $user = User::orderBY(DB::raw('RAND()'))->first()->id;

        for($i =0 ; $i < 50; $i++) {
            Car::create([
                'user_id' => 2,
                'model_id' => CarModel::orderBY(DB::raw('RAND()'))->first()->id,
                'year' => $faker->year,
                'mileage' => $faker->numberBetween('5000','20000'),
                'price' => $faker->numberBetween('1000','20000'),
                'mobile' => $faker->randomNumber()
            ]);
        }

    }
}