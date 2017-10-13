<?php

use Illuminate\Database\Seeder;
use App\Actor;
use App\ActorName;

class ActorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = ['Decisor sobre cedencia de transporte', 'Decisor sobre cedencia de apoios', 'Requerente de transporte'];

        foreach ($datas as $data) {
            $new = factory(Actor::class, 1)->create();

            factory(ActorName::class, 1)->create([
                'actor_id'    => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        factory(Actor::class, 5)->create()->each(function($new) {
            factory(ActorName::class, 1)->create([
                'actor_id'    => $new->id, 
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        });*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'          => '1',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '2',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '3',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            Actor::create($value);
        }
    }
}
