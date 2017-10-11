<?php

use Illuminate\Database\Seeder;
use App\PropUnitTypeName;

class PropUnitTypeNameTableSeeder extends Seeder
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
        		'prop_unit_type_id' => '1',
        		'language_id'       => '1',
        		'name'              => 'kg',
                'updated_by'        => '1',
                'deleted_by'        => NULL
        	],
        	[
        		'prop_unit_type_id' => '2',
        		'language_id'       => '1',
        		'name'              => 'mg',
                'updated_by'        => '1',
                'deleted_by'        => NULL
        	],
        	[
        		'prop_unit_type_id' => '3',
        		'language_id'       => '1',
        		'name'              => 'cm',
                'updated_by'        => '1',
                'deleted_by'        => NULL
        	],
        	[
        		'prop_unit_type_id' => '4',
        		'language_id'       => '1',
        		'name'              => 'm',
                'updated_by'        => '1',
                'deleted_by'        => NULL
        	],
        ];

        foreach ($dados as $value) {
            PropUnitTypeName::create($value);
        }
    }
}
