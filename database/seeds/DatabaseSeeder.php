<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
	private $tables = [
		'users',
		'password_resets',
		'cars',
		'car_makes',
		'car_brands',
		'car_types',
		'car_models',
		'jobs',
		'tags',
		'taggables',
		'messages',
		'threads',
		'participants',
		'notifications',
		'photos'
	];
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->cleanDatabase();
		$this->call('UserSeeder');
		$this->call('CarMakeSeeder');
		$this->call('CarBrandSeeder');
		$this->call('CarTypeSeeder');
		$this->call('CarModelSeeder');
		$this->call('CarSeeder');
		$this->call('TagTableSeeder');
//		$this->call('MessageSeeder');
	}

	private function cleanDatabase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		foreach ($this->tables as $table) {
			DB::table($table)->truncate();
		}
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}


}
