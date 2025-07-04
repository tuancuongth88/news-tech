<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'admin',
            'email' => Str::random(10) . '@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        $this->call(CategorySeeder::class);
    }
}
