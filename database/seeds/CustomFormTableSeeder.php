<?php

use Illuminate\Database\Seeder;
use App\CustomForm;

class CustomFormTableSeeder extends Seeder
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
        		'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '2',
        		'state'      => 'inactive',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'id'         => '3',
        		'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => '1'
        	]
        ];

        foreach ($dados as $value) {
            CustomForm::create($value);
        }
    }
}
