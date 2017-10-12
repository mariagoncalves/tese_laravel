<?php

use Illuminate\Database\Seeder;
use App\WaitingLink;

class WaitingLinkTableSeeder extends Seeder
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
                'waited_t'            => '2',
                'waited_fact'         => '4',
                'waiting_fact'        => '5',
                'waiting_transaction' => '1',
                'min'                 => '1',
                'max'                 => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
        	[
        		'id'                  => '2',
                'waited_t'            => '1',
                'waited_fact'         => '4',
                'waiting_fact'        => '5',
                'waiting_transaction' => '3',
                'min'                 => '1',
                'max'                 => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
        	[
        		'id'                  => '3',
                'waited_t'            => '2',
                'waited_fact'         => '4',
                'waiting_fact'        => '5',
                'waiting_transaction' => '1',
                'min'                 => '1',
                'max'                 => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	]
        ];

        foreach ($dados as $value) {
            WaitingLink::create($value);
        }
    }
}
