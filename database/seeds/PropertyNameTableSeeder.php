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
        $dados = [
        	[
        		'property_id'     => '1',
        		'language_id'     => '1',
        		'name'            => 'Numero de Pessoas',
        		'form_field_name' => 'Numero',
                'updated_by'      => '1',
                'deleted_by'      => '1'
        	],
        	[
        		'property_id'     => '1',
        		'language_id'     => '2',
        		'name'            => 'Number of people',
        		'form_field_name' => 'Number',
                'updated_by'      => '1',
                'deleted_by'      => '1'
        	],
            [
                'property_id'     => '2',
                'language_id'     => '1',
                'name'            => 'Objetivo',
                'form_field_name' => 'Objetivo',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ],
             [
                'property_id'     => '2',
                'language_id'     => '2',
                'name'            => 'Objective',
                'form_field_name' => 'Objective',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ],
            [
                'property_id'     => '3',
                'language_id'     => '1',
                'name'            => 'Área',
                'form_field_name' => 'Area',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ],
            [
        		'property_id'     => '3',
        		'language_id'     => '2',
        		'name'            => 'Area',
        		'form_field_name' => 'Area',
                'updated_by'      => '1',
                'deleted_by'      => '1'
        	],
        	[
        		'property_id'     => '4',
        		'language_id'     => '1',
        		'name'            => 'Preço',
        		'form_field_name' => 'Preço',
                'updated_by'      => '1',
                'deleted_by'      => '1'
        	],
            [
                'property_id'     => '4',
                'language_id'     => '2',
                'name'            => 'Price',
                'form_field_name' => 'Price',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ],
             [
                'property_id'     => '5',
                'language_id'     => '1',
                'name'            => 'Quantidade',
                'form_field_name' => 'Quantidade',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ],
            [
                'property_id'     => '5',
                'language_id'     => '2',
                'name'            => 'Quantity',
                'form_field_name' => 'Quantity',
                'updated_by'      => '1',
                'deleted_by'      => '1'
            ]

        ];

        foreach ($dados as $value) {
            PropertyName::create($value);
        }
    }
}
