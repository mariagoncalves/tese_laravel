<?php

use Illuminate\Database\Seeder;
use App\ActorIniciatesT;

class ActorIniciatesTTableSeeder extends Seeder
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
        		'transaction_type_id' => '1',
        		'actor_id'            => '1',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[	'transaction_type_id' => '2',
        		'actor_id'            => '1',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	],
        	[
        		'transaction_type_id' => '3',
        		'actor_id'            => '1',
                'updated_by'          => '1',
                'deleted_by'          => '1'
        	]
        ];

        foreach ($dados as $value) {
            ActorIniciatesT::create($value);
        }
    }
}
