<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\RoleName;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Administrador', 'Munícipe', 'Administrativo'];

        foreach ($datas as $data) {
            $new = factory(Role::class, 1)->create();

            factory(RoleName::class, 1)->create([
                'role_id'     => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        factory(Role::class, 4)->create()->each(function($new) {
            factory(RoleName::class, 1)->create([
                'role_id'     => $new->id, 
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        });

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'         => '1',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '2',
                'updated_by' => '1',
                'deleted_by' => NULL
            ]
        ];

        foreach ($dados as $value) {
            Role::create($value);
        }
    }
}
