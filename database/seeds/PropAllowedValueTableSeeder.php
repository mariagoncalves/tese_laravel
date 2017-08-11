<?php

use Illuminate\Database\Seeder;
use App\PropAllowedValue;

class PropAllowedValueTableSeeder extends Seeder
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
        		'id'          => '1',
        		'property_id' => '4',
        		'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'id'          => '2',
        		'property_id' => '5',
        		'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            PropAllowedValue::create($value);
        }
    }
}
