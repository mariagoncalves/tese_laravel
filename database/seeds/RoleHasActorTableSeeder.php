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
        factory(RoleHasActor::class, 2)->create();

        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'role_id'    => '1',
        		'actor_id'   => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
        	],
        	[	'role_id'    => '2',
        		'actor_id'   => '3',
                'updated_by' => '1',
                'deleted_by' => NULL
        	]
        ];

        foreach ($dados as $value) {
            RoleHasActor::create($value);
        }
    }
}
