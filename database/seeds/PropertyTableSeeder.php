<?php

use Illuminate\Database\Seeder;
use App\Property;


class PropertyTableSeeder extends Seeder
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
        		'id'               => '1',
        		'ent_type_id'      => '1',
        		'rel_type_id'      => NULL,
        		'value_type'       => 'text',
        		'form_field_type'  => 'text',
        		'unit_type_id'     => '1',
        		'form_field_order' => '1',
        		'mandatory'        => '1',
        		'state'            => 'active',
        		'fk_ent_type_id'   => NULL,
        		'form_field_size'  => '50',
                'updated_by'       => '1',
                'deleted_by'       => '1'
        	],
        	[
        		'id'               => '2',
        		'ent_type_id'      => '2',
        		'rel_type_id'      => NULL,
        		'value_type'       => 'text',
        		'form_field_type'  => 'text',
        		'unit_type_id'     => '1',
        		'form_field_order' => '2',
        		'mandatory'        => '1',
        		'state'            => 'active',
        		'fk_ent_type_id'   => NULL,
        		'form_field_size'  => '50',
                'updated_by'       => '1',
                'deleted_by'       => '1'
        	],
            [
                'id'               => '3',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => '1',
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'form_field_size'  => '50',
                'updated_by'       => '1',
                'deleted_by'       => '1'
            ],
            [
                'id'               => '4',
                'ent_type_id'      => NULL,
                'rel_type_id'      => '1',
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => '1',
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'form_field_size'  => '50',
                'updated_by'       => '1',
                'deleted_by'       => '1'
            ],
            [
                'id'               => '5',
                'ent_type_id'      => NULL,
                'rel_type_id'      => '2',
                'value_type'       => 'enum',
                'form_field_type'  => 'checkbox',
                'unit_type_id'     => '1',
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'form_field_size'  => '50',
                'updated_by'       => '1',
                'deleted_by'       => '1'
            ]

        ];

        foreach ($dados as $value) {
            Property::create($value);
        }
    }
}
