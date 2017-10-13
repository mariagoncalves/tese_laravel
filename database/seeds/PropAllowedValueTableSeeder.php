<?php

use Illuminate\Database\Seeder;
use App\PropAllowedValue;
use App\PropAllowedValueName;
use App\Property;

class PropAllowedValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$properties = Property::where('value_type', 'enum')->get();

        foreach ($properties as $prop) {
            factory(PropAllowedValue::class, 5)->create(['property_id' => $prop->id])->each(function($new) {
                factory(PropAllowedValueName::class, 1)->create([
                    'p_a_v_id'   => $new->id, 
                    'updated_by' => $new->updated_by,
                ]);
            });
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'          => '1',
                'property_id' => '12',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '2',
                'property_id' => '12',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '3',
                'property_id' => '12',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '4',
                'property_id' => '12',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '5',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '6',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '7',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '8',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '9',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '10',
                'property_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            PropAllowedValue::create($value);
        }
    }
}
