<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cryptocurrencies')->insert([
            'name' => 'first',
            'stockvalue' => rand(10, 100)
        ]);
        DB::table('cryptocurrencies')->insert([
            'name' => 'second',
            'stockvalue' => rand(10, 100)
        ]);
        DB::table('cryptocurrencies')->insert([
            'name' => 'third',
            'stockvalue' => rand(10, 100)
        ]);
        DB::table('cryptocurrencies')->insert([
            'name' => 'fourth',
            'stockvalue' => rand(10, 100)
        ]);
        DB::table('cryptocurrencies')->insert([
            'name' => 'fifth',
            'stockvalue' => rand(10, 100)
        ]);
    }
}
