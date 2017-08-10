<?php

use Illuminate\Database\Seeder;
use App\EntType;

class EntTypeTableSeeder extends Seeder
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
        		'state'               => 'active',
        		'has_child'           => '0',
        		'has_par'             => '0',
        		'transaction_type_id' => '1',
        		'par_ent_type_id'     => NULL,
        		'par_prop_type_val'   => NULL,
        		't_state_id'          => '4',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[	'id'                  => '2',
        		'state'               => 'active',
        		'has_child'           => '0',
        		'has_par'             => '0',
        		'transaction_type_id' => '2',
        		'par_ent_type_id'     => NULL,
        		'par_prop_type_val'   => NULL,
        		't_state_id'          => '4',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'id'                  => '3',
        		'state'               => 'active',
        		'has_child'           => '0',
        		'has_par'             => '0',
        		'transaction_type_id' => '3',
        		'par_ent_type_id'     => NULL,
        		'par_prop_type_val'   => NULL,
        		't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	]
        ];

        foreach ($dados as $value) {
            EntType::create($value);
        }
    }
}
