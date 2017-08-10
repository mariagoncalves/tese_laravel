<?php

use Illuminate\Database\Seeder;
use App\EntityName;

class EntityNameTableSeeder extends Seeder
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
        		'entity_id'   => '1',
        		'language_id' => '1',
        		'name'        => 'Transporte Crianças de escola',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'entity_id'   => '1',
        		'language_id' => '2',
        		'name'        => 'Transportation School children',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'entity_id'   => '2',
        		'language_id' => '1',
        		'name'        => 'Apoio para concerto',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'entity_id'   => '2',
        		'language_id' => '2',
        		'name'        => 'Concert Support',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'entity_id'   => '3',
        		'language_id' => '1',
        		'name'        => 'Concurso Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'entity_id'   => '3',
        		'language_id' => '2',
        		'name'        => 'Contest Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            EntityName::create($value);
        }
    }
}
