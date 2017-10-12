<?php

use Illuminate\Database\Seeder;
use App\CausalLink;

class CausalLinkTableSeeder extends Seeder
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
        		'id'         => '1',
        		'causing_t'  => '2',
        		't_state_id' => '1',
                'caused_t'   => '1',
                'min'        => '1',
                'max'        => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
        	],
        	[	'id'         => '2',
        		'causing_t'  => '1',
        		't_state_id' => '2',
                'caused_t'   => '1',
                'min'        => '1',
                'max'        => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
        	],
        	[
        		'id'         => '3',
        		'causing_t'  => '1',
        		't_state_id' => '3',
                'caused_t'   => '3',
                'min'        => '1',
                'max'        => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
        	]
        ];

        foreach ($dados as $value) {
            CausalLink::create($value);
        }
    }
}
