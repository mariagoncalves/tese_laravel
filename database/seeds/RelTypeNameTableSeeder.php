<?php

use Illuminate\Database\Seeder;
use App\RelTypeName;

class RelTypeNameTableSeeder extends Seeder
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
        		'rel_type_id' => '1',
        		'language_id' => '1',
        		'name'        => 'Relacao 1',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'rel_type_id' => '1',
        		'language_id' => '2',
        		'name'        => 'Relation 1',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'rel_type_id' => '2',
        		'language_id' => '1',
        		'name'        => 'Relacao 2',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'rel_type_id' => '2',
        		'language_id' => '2',
        		'name'        => 'Relation 2',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];
    }
}
