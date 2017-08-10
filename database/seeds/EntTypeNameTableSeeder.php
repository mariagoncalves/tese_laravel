<?php

use Illuminate\Database\Seeder;
use App\EntTypeName;

class EntTypeNameTableSeeder extends Seeder
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
        		'ent_type_id' => '1',
        		'language_id' => '1',
        		'name'        => 'Transporte',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'ent_type_id' => '1',
        		'language_id' => '2',
        		'name'        => 'Transport',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'ent_type_id' => '2',
        		'language_id' => '1',
        		'name'        => 'Apoios',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'ent_type_id' => '2',
        		'language_id' => '2',
        		'name'        => 'Supports',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'ent_type_id' => '3',
        		'language_id' => '1',
        		'name'        => 'Concurso',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'ent_type_id' => '3',
        		'language_id' => '2',
        		'name'        => 'Contests',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            EntTypeName::create($value);
        }
    }
}
