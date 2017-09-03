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
        $dados = [
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
        }

    }
}
