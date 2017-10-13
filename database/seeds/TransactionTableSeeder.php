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
        //factory(Transaction::class, 15)->create();

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'                  => '1',
                'transaction_type_id' => '1',
                'state'               => 'active',
                'process_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [   'id'                  => '2',
                'transaction_type_id' => '1',
                'state'               => 'active',
                'process_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [   'id'                  => '3',
                'transaction_type_id' => '1',
                'state'               => 'active',
                'process_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ]
        ];

        foreach ($dados as $value) {
            Transaction::create($value);
        }
    }
}
