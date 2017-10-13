<?php

use Illuminate\Database\Seeder;
use App\RoleHasUser;

class RoleHasUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(RoleHasUser::class, 2)->create();

        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'role_id'    => '1',
        		'user_id'    => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
        	],
        	[	'role_id'    => '2',
        		'user_id'    => '2',
                'updated_by' => '1',
                'deleted_by' => NULL
        	]
        ];

        foreach ($dados as $value) {
            RoleHasUser::create($value);
        }
    }
}
