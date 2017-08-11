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
        $dados = [
        	[
        		'role_id' => '1',
        		'user_id'  => '1',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'role_id' => '2',
        		'user_id'  => '2',
                'updated_by' => '1',
                'deleted_by' => '1'
        	],
        	[
        		'role_id' => '3',
        		'user_id'  => '3',
                'updated_by' => '1',
                'deleted_by' => '1'
        	]
        ];

        foreach ($dados as $value) {
            RoleHasUser::create($value);
        }
    }
}
