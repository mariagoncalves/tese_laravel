<?php

use Illuminate\Database\Seeder;
use App\TransactionAck;

class TransactionAckTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TransactionAck::class, 15)->create();
    }
}
