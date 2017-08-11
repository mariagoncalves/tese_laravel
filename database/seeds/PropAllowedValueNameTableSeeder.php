<?php

use Illuminate\Database\Seeder;
use App\PropAllowedValueName;

class PropAllowedValueNameTableSeeder extends Seeder
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
        		'p_a_v_id'    => '1',
        		'language_id' => '1',
        		'name'        => '5 euros',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'p_a_v_id'    => '1',
        		'language_id' => '2',
        		'name'        => '5 pounds',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'p_a_v_id'    => '2',
        		'language_id' => '1',
        		'name'        => '5 km',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'p_a_v_id'    => '2',
        		'language_id' => '2',
        		'name'        => '5 inches',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        ];

        foreach ($dados as $value) {
            PropAllowedValueName::create($value);
        }
    }
}
