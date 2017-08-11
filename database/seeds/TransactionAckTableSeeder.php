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
        $dados = [
        	[
        		'id'                   => '1',
                'user_id'              => '1',
                'viewed_on'            => date("Y-m-d H:i:s"),
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => '1'
        	],
        	[
        		'id'                   => '2',
                'user_id'              => '1',
                'viewed_on'            => date("Y-m-d H:i:s"),
                'transaction_state_id' => '2',
                'updated_by'           => '1',
                'deleted_by'           => '1'
        	],
        	[
        		'id'                   => '3',
                'user_id'              => '1',
                'viewed_on'            => date("Y-m-d H:i:s"),
                'transaction_state_id' => '3',
                'updated_by'           => '1',
                'deleted_by'           => '1'
        	]
        ];

        foreach ($dados as $value) {
            TransactionAck::create($value);
        }
    }
}
