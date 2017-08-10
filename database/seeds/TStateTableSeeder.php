<?php

use Illuminate\Database\Seeder;
use App\TState;

class TStateTableSeeder extends Seeder
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
        		'id'         => '1',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '2',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '3',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '4',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '5',
                'updated_by' => '1',
                'deleted_by' => '1'
        	]
        ];

        foreach ($dados as $value) {
            TState::create($value);
        }
    }
}
