<?php

use Illuminate\Database\Seeder;
use App\RoleHasActor;

class RoleHasActorTableSeeder extends Seeder
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
        		'role_id'   => '1',
        		'actor_id'   => '2',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'role_id'    => '2',
        		'actor_id'   => '3',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'role_id'    => '3',
        		'actor_id'   => '1',
                'updated_by' => '1',
                'deleted_by' => '1'
        	]
        ];

        foreach ($dados as $value) {
            RoleHasActor::create($value);
        }
    }
}
