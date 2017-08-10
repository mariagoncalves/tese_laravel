<?php

use Illuminate\Database\Seeder;
use App\Entity;

class EntityTableSeeder extends Seeder
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
        		'ent_type_id' => '1',
        		'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'id'          => '2',
        		'ent_type_id' => '2',
        		'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'id'          => '3',
        		'ent_type_id' => '3',
        		'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            Entity::create($value);
        }
    }
}
