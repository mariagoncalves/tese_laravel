<?php

use Illuminate\Database\Seeder;
use App\RelationName;

class RelationNameTableSeeder extends Seeder
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
        		'relation_id' => '1',
                'language_id' => '1',
                'name'        => 'Inst Relacao 1',
                'updated_by'  => '1',
                'deleted_by'  => '1'

        	],
        	[
        		'relation_id' => '1',
                'language_id' => '2',
                'name'        => 'Inst Relation 1',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'relation_id' => '2',
                'language_id' => '1',
                'name'        => 'Inst Relacao 2',
                'updated_by'  => '1',
                'deleted_by'  => '1'

        	],
        	[
        		'relation_id' => '2',
                'language_id' => '2',
                'name'        => 'Inst Relation 2',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            RelationName::create($value);
        }
    }
}
