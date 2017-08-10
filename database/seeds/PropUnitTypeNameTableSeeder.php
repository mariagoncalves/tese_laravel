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
        		'name'              => 'quilograma',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '1',
        		'language_id'       => '2',
        		'name'              => 'kilogram',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '2',
        		'language_id'       => '1',
        		'name'              => 'metros',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '2',
        		'language_id'       => '2',
        		'name'              => 'meters',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '3',
        		'language_id'       => '1',
        		'name'              => 'polegadas',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '3',
        		'language_id'       => '2',
        		'name'              => 'inches',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '4',
        		'language_id'       => '1',
        		'name'              => 'libras',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	],
        	[
        		'prop_unit_type_id' => '4',
        		'language_id'       => '2',
        		'name'              => 'pounds',
                'updated_by'        => '1',
                'deleted_by'        => '1'
        	]
        ];

        foreach ($dados as $value) {
            PropUnitTypeName::create($value);
        }
    }
}
