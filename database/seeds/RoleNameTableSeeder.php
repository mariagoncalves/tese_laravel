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
        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'role_id'     => '1',
                'language_id' => '1',
                'name'        => 'Administrador',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'role_id'     => '2',
                'language_id' => '1',
                'name'        => 'Munícipe',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            RoleName::create($value);
        }
    }
}
