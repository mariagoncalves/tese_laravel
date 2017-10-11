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
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'ent_type_id' => '1',
        		'language_id' => '1',
        		'name'        => 'Transporte',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'ent_type_id' => '2',
                'language_id' => '1',
                'name'        => 'Concurso',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	'ent_type_id' => '3',
                'language_id' => '1',
                'name'        => 'Apoios',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'ent_type_id' => '4',
                'language_id' => '1',
                'name'        => 'Pessoa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'ent_type_id' => '5',
                'language_id' => '1',
                'name'        => 'Freguesia',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            EntTypeName::create($value);
        }
    }
}
