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
        $datas = ['Pedido','Promessa','Execução','Afirmação','Aceitação'];

        foreach ($datas as $data) {
            $new = factory(TState::class, 1)->create();

            factory(TStateName::class, 1)->create([
                't_state_id'  => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }
    }
}
