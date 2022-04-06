<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'kuropanda63',
        ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'role' => 'admin',
        ]);
    }
}
