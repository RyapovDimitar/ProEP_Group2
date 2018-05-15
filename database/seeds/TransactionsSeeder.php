<?php

use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usercurrency')->insert([
            'user_id' => 1,
            'crypto_id' => 1,
            'balance' => 100
        ]);
        DB::table('transactions')->insert([
            'user_id' => 1,
            'crypto_id' => 1,
            'usercurrency_id' => 1,
            'cryptoQuantity' => 100,
            'positive' => true
        ]);
        DB::table('usercurrency')->insert([
            'user_id' => 1,
            'crypto_id' => 2,
            'balance' => 200
        ]);
        DB::table('transactions')->insert([
            'user_id' => 1,
            'crypto_id' => 2,
            'usercurrency_id' => 2,
            'cryptoQuantity' => 150,
            'positive' => true
        ]);
        DB::table('transactions')->insert([
            'user_id' => 1,
            'crypto_id' => 2,
            'usercurrency_id' => 2,
            'cryptoQuantity' => 50,
            'positive' => true
        ]);
    }
}
