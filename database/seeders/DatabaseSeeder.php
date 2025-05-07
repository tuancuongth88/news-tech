<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'tinh',
            'email' => str_random(10) . '@gmail.com',
            'password' => bcrypt('hayhayhay'),
        ]);
    }
}
