<?php

use Illuminate\Database\Seeder;
use App\Value;
use App\ValueName;

class ValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Value::class, 5)->create()->each(function($new) {
            factory(ValueName::class, 1)->create([
                'value_id'   => $new->id, 
                'updated_by' => $new->updated_by,
            ]);
        });

    }
}
