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
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'custom_form_id' => '1',
        		'language_id'    => '1',
        		'name'           => 'Formulário de Cedência de Transporte',
                'updated_by'     => '1',
                'deleted_by'     => NULL
        	],
        	[
        		'custom_form_id' => '2',
        		'language_id'    => '1',
        		'name'           => 'Formulário participar em Concurso',
                'updated_by'     => '1',
                'deleted_by'     => NULL
        	],
        	[
        		'custom_form_id' => '3',
        		'language_id'    => '1',
        		'name'           => 'Formulário de pedido de apoios',
                'updated_by'     => '1',
                'deleted_by'     => NULL
        	],
        	[
        		'custom_form_id' => '4',
        		'language_id'    => '1',
        		'name'           => 'Formulário dados pessoais',
                'updated_by'     => '1',
                'deleted_by'     => NULL
        	]
        ];

        foreach ($dados as $value) {
            CustomFormName::create($value);
        }
    }
}
