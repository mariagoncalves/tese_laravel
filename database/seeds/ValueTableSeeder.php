<?php

use Illuminate\Database\Seeder;
use App\Value;

class ValueTableSeeder extends Seeder
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
        		'id'          => '1',
                'entity_id'   => '1',
                'property_id' => '1',
                'id_producer' => '1' ,
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'id'          => '2',
                'entity_id'   => '2',
                'property_id' => '2',
                'id_producer' => '1' ,
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'id'          => '3',
                'entity_id'   => '3',
                'property_id' => '3',
                'id_producer' => '1' ,
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            Value::create($value);
        }
    }
}
