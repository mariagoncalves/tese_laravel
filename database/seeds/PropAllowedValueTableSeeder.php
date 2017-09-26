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
        $properties = Property::where('value_type', 'enum')->get();

        foreach ($properties as $prop) {
            factory(PropAllowedValue::class, 5)->create(['property_id' => $prop->id])->each(function($new) {
                factory(PropAllowedValueName::class, 1)->create([
                    'p_a_v_id'   => $new->id, 
                    'updated_by' => $new->updated_by,
                ]);
            });
        }
    }
}
