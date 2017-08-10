<?php

use Illuminate\Database\Seeder;
use App\TransactionTypeName;

class TransactionTypeNameTableSeeder extends Seeder
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
        		'transaction_type_id' => '1',
        		'language_id'         => '1',
        		't_name'              => 'Decisao sobre cedencia de transporte',
        		'rt_name'             => 'Decisao sobre cedencia de transporte foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '1',
        		'language_id'         => '2',
        		't_name'              => 'Decision on transfer of transport',
        		'rt_name'             => 'Decision on transfer of transport occured',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '2',
        		'language_id'         => '1',
        		't_name'              => 'Decisão sobre apoios',
        		'rt_name'             => 'Decisão sobre apoios foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '2',
        		'language_id'         => '2',
        		't_name'              => 'Decision on supports',
        		'rt_name'             => 'Decision on supports occured',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '3',
        		'language_id'         => '1',
        		't_name'              => 'Solicitação de pedido',
        		'rt_name'             => 'Solicitação de pedido foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '3',
        		'language_id'         => '2',
        		't_name'              => 'Order request',
        		'rt_name'             => 'Order request occured',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	]
        ];

        foreach ($dados as $value) {
            TransactionTypeName::create($value);
        }
    }
}
