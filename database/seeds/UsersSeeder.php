<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'first',
            'password' => bcrypt('secret'),
            'is_admin' => true,
            'token' => str_random(10)
        ]);
        DB::table('users')->insert([
            'username' => 'second',
            'password' => bcrypt('secret'),
            'is_admin' => false,
            'token' => str_random(10)
        ]);
        DB::table('users')->insert([
            'username' => 'third',
            'password' => bcrypt('secret'),
            'is_admin' => false,
            'token' => str_random(10)
        ]);
    }
}
