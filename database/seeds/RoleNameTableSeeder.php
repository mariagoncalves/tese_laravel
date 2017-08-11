<?php

use Illuminate\Database\Seeder;
use App\RoleName;

class RoleNameTableSeeder extends Seeder
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
        		'role_id'     => '1',
        		'language_id' => '1',
        		'name'        => 'Administrador',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'role_id'     => '1',
        		'language_id' => '2',
        		'name'        => 'Admin',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'role_id'     => '2',
        		'language_id' => '1',
        		'name'        => 'Munícipe',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'role_id'     => '2',
        		'language_id' => '2',
        		'name'        => 'Citizen',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[
        		'role_id'     => '3',
        		'language_id' => '1',
        		'name'        => 'Administrativo',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	],
        	[	'role_id'     => '3',
        		'language_id' => '2',
        		'name'        => 'Administrative',
                'updated_by'  => '1',
                'deleted_by'  => '1'
        	]
        ];

        foreach ($dados as $value) {
            RoleName::create($value);
        }
    }
}
