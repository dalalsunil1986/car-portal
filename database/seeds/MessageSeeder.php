<?php

use App\Src\Car\Car;
use App\Src\Message\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i=1;$i<5;$i++) {
            $userId = [2,3];
            Message::create([
                'thread_id' => 1,
                'sender_id'    => $faker->randomElement($userId),
                'recepient_id'    => 1,
                'body'    => $faker->text(),
            ]);
        }

    }
}