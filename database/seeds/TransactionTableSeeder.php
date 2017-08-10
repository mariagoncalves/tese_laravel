<?php

use Illuminate\Database\Seeder;
use App\Transaction;

class TransactionTableSeeder extends Seeder
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
        		'id'                  => '1',
        		'transaction_type_id' => '1',
        		'state'               => 'active',
        		'process_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'id'                  => '2',
        		'transaction_type_id' => '1',
        		'state'               => 'active',
        		'process_id'          => '2',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'id'                  => '3',
        		'transaction_type_id' => '1',
        		'state'               => 'active',
        		'process_id'          => '3',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	]
        ];

        foreach ($dados as $value) {
            Transaction::create($value);
        }
    }
}
