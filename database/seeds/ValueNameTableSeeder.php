<?php

use Illuminate\Database\Seeder;
use App\ValueName;

class ValueNameTableSeeder extends Seeder
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
        		'value_id'    => '1',
                'language_id' => '1',
                'name'        => 'Dez',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'value_id'    => '1',
                'language_id' => '2',
                'name'        => 'Ten',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'value_id'    => '2',
                'language_id' => '1',
                'name'        => 'Campanha',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'value_id'    => '2',
                'language_id' => '2',
                'name'        => 'Campaign',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'value_id'    => '3',
                'language_id' => '1',
                'name'        => 'Cinco',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'value_id'    => '3',
                'language_id' => '2',
                'name'        => 'Five',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            ValueName::create($value);
        }
    }
}
