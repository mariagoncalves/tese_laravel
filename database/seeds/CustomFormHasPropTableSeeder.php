<?php

use Illuminate\Database\Seeder;
use App\CustomFormHasProp;

class CustomFormHasPropTableSeeder extends Seeder
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
        		'property_id'    => '1',
        		'custom_form_id' => '1',
        		'field_order'    => '1',
                'mandatory_form' => '1',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[	'property_id'    => '2',
        		'custom_form_id' => '2',
        		'field_order'    => '1',
                'mandatory_form' => '1',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	],
        	[
        		'property_id'    => '3',
        		'custom_form_id' => '3',
        		'field_order'    => '1',
                'mandatory_form' => '1',
                'updated_by'     => '1',
                'deleted_by'     => '1'
        	]
        ];

        foreach ($dados as $value) {
            CustomFormHasProp::create($value);
        }
    }
}
