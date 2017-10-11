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

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'                   => '1',
                'user_id'              => '1',
                'viewed_on'            => '2017-09-23 16:21:05',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '2',
                'user_id'              => '1',
                'viewed_on'            => '2017-09-23 16:21:05',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '3',
                'user_id'              => '1',
                'viewed_on'            => '2017-09-23 16:21:05',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ]
        ];

        foreach ($dados as $value) {
            TransactionAck::create($value);
        }
    }
}
