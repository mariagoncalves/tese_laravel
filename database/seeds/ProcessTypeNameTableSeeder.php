<?php

use Illuminate\Database\Seeder;
use App\ProcessTypeName;

class ProcessTypeNameTableSeeder extends Seeder
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
        		'process_type_id' => '1',
        		'language_id'     => '1',
        		'name'            => 'Gestão de transportes',
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
        	[
        		'process_type_id' => '2',
        		'language_id'     => '1',
        		'name'            => 'Gestão de concursos',
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
        	[
        		'process_type_id' => '3',
        		'language_id'     => '1',
        		'name'            => 'Gestão de apoios',
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'process_type_id' => '3',
                'language_id'     => '1',
                'name'            => 'Gestão de pessoas',
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ]
        ];

        foreach ($dados as $value) {
            ProcessTypeName::create($value);
        }
    }
}
