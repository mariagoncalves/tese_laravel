<?php

use Illuminate\Database\Seeder;
use App\Relation;

class RelationTableSeeder extends Seeder
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
                'rel_type_id' => '1',
                'entity1_id'  => '1',
                'entity2_id'  => '2',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'

        	],
        	[
        		'id'          => '2',
                'rel_type_id' => '2',
                'entity1_id'  => '1',
                'entity2_id'  => '3',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            Relation::create($value);
        }
    }
}
