<?php

use Illuminate\Database\Seeder;
use App\Operator;

class OperatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'id'            => '1',
        		'operator_type' => '<',
                'updated_by'    => '1',
                'deleted_by'    => NULL
        	],
        	[
        		'id'            => '2',
        		'operator_type' => '>',
                'updated_by'    => '1',
                'deleted_by'    => NULL
        	],
        	[
        		'id'            => '3',
        		'operator_type' => '=',
                'updated_by'    => '1',
                'deleted_by'    => NULL
        	],
        	[
        		'id'            => '4',
        		'operator_type' => '!=',
                'updated_by'    => '1',
                'deleted_by'    => NULL
        	],
        	[
        		'id'            => '5',
        		'operator_type' => '~',
                'updated_by'    => '1',
                'deleted_by'    => NULL
        	]
        ];

        foreach ($dados as $value) {
            Operator::create($value);
        }
    }
}
