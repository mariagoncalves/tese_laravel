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
        //factory(TransactionState::class, 15)->create();

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'              => '1',
                'transaction_id'  => '1',
                't_state_id'      => '1',
                'd_init_state_id' => NULL,
                'd_exec_state_id' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [   'id'              => '2',
                'transaction_id'  => '1',
                't_state_id'      => '1',
                'd_init_state_id' => NULL,
                'd_exec_state_id' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [   'id'              => '3',
                'transaction_id'  => '1',
                't_state_id'      => '1',
                'd_init_state_id' => NULL,
                'd_exec_state_id' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ]
        ];

        foreach ($dados as $value) {
            TransactionState::create($value);
        }
    }
}
