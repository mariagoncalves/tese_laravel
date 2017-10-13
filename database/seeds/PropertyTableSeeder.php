<?php

use Illuminate\Database\Seeder;
use App\Property;
use App\PropertyName;


class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = ['Nome', 'Rua'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create(['value_type' => 'text']);

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        $datas = ['Numero de Pessoas', 'Objetivo', 'Área', 'Preço', 'Quantidade'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create();

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        $datas = ['Idade', 'Profissão'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create(['value_type' => 'enum']);

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'               => '1',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '2',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '3',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '4',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '50',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '5',
                'ent_type_id'      => '2',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '6',
                'ent_type_id'      => '2',
                'rel_type_id'      => NULL,
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '7',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '8',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '9',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '10',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '11',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'bool',
                'form_field_type'  => 'radio',
                'unit_type_id'     => NULL,
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '12',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '6',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '13',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '14',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '15',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '16',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                'value_type'       => 'ent_ref',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => '5',
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '17',
                'ent_type_id'      => '5',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '18',
                'ent_type_id'      => '5',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
        ];

        foreach ($dados as $value) {
            Property::create($value);
        }
    }
}
