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

        factory(Role::class, 2)->create()->each(function($new) {
            factory(RoleName::class, 1)->create([
                'role_id'     => $new->id, 
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        });
    }
}
