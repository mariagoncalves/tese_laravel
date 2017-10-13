<?php

use Illuminate\Database\Seeder;
use App\TState;
use App\TStateName;

class TStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = ['Pedido','Promessa','Execução','Afirmação','Aceitação'];

        foreach ($datas as $data) {
            $new = factory(TState::class, 1)->create();

            factory(TStateName::class, 1)->create([
                't_state_id'  => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }*/
        
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
            ],
            [
                'id'          => '4',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '5',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]

        ];

        foreach ($dados as $value) {
            TState::create($value);
        }
    }
}
