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
        $dados = [
        	[
        		'id'             => '1',
                'transaction_id' => '1',
                't_state_id'     => '1',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'id'             => '2',
                'transaction_id' => '1',
                't_state_id'     => '2',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'id'             => '3',
                'transaction_id' => '1',
                't_state_id'     => '3',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	]
        ];

        foreach ($dados as $value) {
            TransactionState::create($value);
        }
    }
}
