<?php

use Illuminate\Database\Seeder;
use App\ProcessName;

class ProcessNameTableSeeder extends Seeder
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
        		'process_id'  => '1',
        		'language_id' => '1',
        		'name'        => 'Gestão de transportes nº1 a ocorrer',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'process_id'  => '1',
        		'language_id' => '2',
        		'name'        => 'Transport management # 1 occurring',
                'updated_by'  => '1',
                'deleted_by'  => '1'
            ],
        	[
        		'process_id'  => '2',
        		'language_id' => '1',
        		'name'        => 'Gestão de concurso nº1 a ocorrer',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'process_id'  => '2',
        		'language_id' => '2',
        		'name'        => 'Contest management # 1 occurring',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'process_id'  => '3',
        		'language_id' => '1',
        		'name'        => 'Gestão de apoios nº1 a ocorrer',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'process_id'  => '3',
        		'language_id' => '2',
        		'name'        => 'Support management # 1 occurring',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            ProcessName::create($value);
        }
    }
}
