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
                'id'         => '1',
                'name'       => 'Português',
                'slug'       => 'pt',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => '1'
            ],
            [   'id'         => '2',
                'name'       => 'Inglês',
                'slug'       => 'en',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => '1'
            ],
            [   'id'         => '3',
                'name'       => 'Espanhol',
                'slug'       => 'es',
                'state'      => 'active',
                'updated_by' => '1',
                'deleted_by' => '1'
            ]
        ];

        foreach ($dados as $value) {
            Language::create($value);
        }
    }
}
