<?php

use Illuminate\Database\Seeder;
use App\PropUnitType;
use App\PropUnitTypeName;

class PropUnitTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['km', 'hm', 'dam', 'm', 'dm', 'cm', 'mm'];

        foreach ($units as $unit) {
            $newUnit = factory(PropUnitType::class, 1)->create();

            factory(PropUnitTypeName::class, 1)->create([
                'prop_unit_type_id' => $newUnit->id, 
                'name'              => $unit,
                'updated_by'        => $newUnit->updated_by,
            ]);
        }

        //Fazendo seeds ao modo antigo
        /*$dados = [
            [
                'id'         => '1',           
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '2',           
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '3',           
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '4',           
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ]
        ];

        foreach ($dados as $value) {
            PropUnitType::create($value);
        }*/
    }
}
