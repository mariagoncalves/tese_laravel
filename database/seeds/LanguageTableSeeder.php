<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$dados = [
            [
                'name'   => 'Português',
                'slug'   => 'pt',
            ],
            [ 
                'name'   => 'Inglês',
                'slug'   => 'en',
            ],
            [
                'name'   => 'Espanhol',
                'slug'   => 'es',
            ]
        ];

        foreach ($dados as $value) {
            factory(Language::class, 1)->create(['name' => $value['name'], 'slug' => $value['slug']]);
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'         => '1',           
                'name'       => 'Português',
                'slug'       => 'pt',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '2',   
                'name'       => 'Inglês',
                'slug'       => 'en',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '3',   
                'name'       => 'Espanhol',
                'slug'       => 'es',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ],
            [
                'id'         => '4',   
                'name'       => 'Francês',
                'slug'       => 'fr',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => NULL
            ]
        ];

        foreach ($dados as $value) {
            Language::create($value);
        }

    }
}
