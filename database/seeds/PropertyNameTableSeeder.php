<?php

use Illuminate\Database\Seeder;
use App\PropertyName;

class PropertyNameTableSeeder extends Seeder
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
        		'property_id'     => '1',
        		'language_id'     => '1',
        		'name'            => 'Qualidade em que faz o pedido',
        		'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
        	[
        		'property_id'     => '2',
                'language_id'     => '1',
                'name'            => 'Tipo de evento',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'property_id'     => '3',
                'language_id'     => '1',
                'name'            => 'Nº crianças',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
             [
                'property_id'     => '4',
                'language_id'     => '1',
                'name'            => 'Local de partida',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '5',
                'language_id'     => '1',
                'name'            => 'Localização do espaço',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '6',
                'language_id'     => '1',
                'name'            => 'Modalidade em que concorre',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
        		'property_id'     => '7',
                'language_id'     => '1',
                'name'            => 'Descrição da atividade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
        	[
        		'property_id'     => '8',
                'language_id'     => '1',
                'name'            => 'Localidade onde irá se desenvolver a atividade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'property_id'     => '9',
                'language_id'     => '1',
                'name'            => 'Destino a dar ao subsídio',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
             [
                'property_id'     => '10',
                'language_id'     => '1',
                'name'            => 'Nº público de beneficiários',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '11',
                'language_id'     => '1',
                'name'            => 'Pessoa coletiva de utilidade pública?',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '12',
                'language_id'     => '1',
                'name'            => 'Tipo de entidade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '13',
                'language_id'     => '1',
                'name'            => 'Nome',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '14',
                'language_id'     => '1',
                'name'            => 'NIF',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '15',
                'language_id'     => '1',
                'name'            => 'Profissão',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '16',
                'language_id'     => '1',
                'name'            => 'Freguesia',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '17',
                'language_id'     => '1',
                'name'            => 'Nº de habitantes',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '18',
                'language_id'     => '1',
                'name'            => 'Área',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '19',
                'language_id'     => '1',
                'name'            => 'Data',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],


        ];

        foreach ($dados as $value) {
            PropertyName::create($value);
        }
    }
}
