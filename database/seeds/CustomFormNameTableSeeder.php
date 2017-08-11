<?php

use Illuminate\Database\Seeder;
use App\CustomFormName;

class CustomFormNameTableSeeder extends Seeder
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
        		'custom_form_id' => '1',
        		'language_id'    => '1',
        		'name'           => 'Formulário de Cedência de Transporte',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'custom_form_id' => '1',
        		'language_id'    => '2',
        		'name'           => 'Transport Form',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'custom_form_id' => '2',
        		'language_id'    => '1',
        		'name'           => 'Formulário de Apoios',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'custom_form_id' => '2',
        		'language_id'    => '2',
        		'name'           => 'Support Form',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'custom_form_id' => '3',
        		'language_id'    => '1',
        		'name'           => 'Formulário de Concursos',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'custom_form_id' => '3',
        		'language_id'    => '2',
        		'name'           => 'Contest Form',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	]
        ];

        foreach ($dados as $value) {
            CustomFormName::create($value);
        }
    }
}
