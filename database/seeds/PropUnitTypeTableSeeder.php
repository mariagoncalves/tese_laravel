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
    }
}
