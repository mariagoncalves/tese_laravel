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
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'entity_id'   => '1',
        		'language_id' => '1',
        		'name'        => 'Transporte Crianças de escola',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	'entity_id'   => '2',
                'language_id' => '1',
                'name'        => 'Apoio para concerto',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'entity_id'   => '3',
                'language_id' => '1',
                'name'        => 'Concurso Funchal Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'entity_id'   => '4',
                'language_id' => '1',
                'name'        => 'Transporte escolar 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	'entity_id'   => '5',
                'language_id' => '1',
                'name'        => 'Freguesia 1',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'entity_id'   => '6',
                'language_id' => '1',
                'name'        => 'Freguesia 2',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'entity_id'   => '7',
                'language_id' => '1',
                'name'        => 'Freguesia 3',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [   'entity_id'   => '8',
                'language_id' => '1',
                'name'        => 'Municipe nº 1234',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'entity_id'   => '9',
                'language_id' => '1',
                'name'        => 'Municipe nº 1235',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'entity_id'   => '10',
                'language_id' => '1',
                'name'        => 'Municipe nº 500',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'entity_id'   => '11',
                'language_id' => '1',
                'name'        => 'Municipe nº 200',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'entity_id'   => '12',
                'language_id' => '1',
                'name'        => 'Municipe nº 600',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]

        ];

        foreach ($dados as $value) {
            EntityName::create($value);
        }
    }
}
