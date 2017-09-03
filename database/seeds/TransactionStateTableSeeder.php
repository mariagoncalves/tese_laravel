<?php

use Illuminate\Database\Seeder;
use App\TransactionState;

class TransactionStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TransactionState::class, 15)->create();
    }
}
