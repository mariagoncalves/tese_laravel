<?php

use Illuminate\Database\Seeder;
use App\EntType;
use App\EntTypeName;

class EntTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Transporte','Apoios','Concurso'];

        foreach ($datas as $data) {
            $new = factory(EntType::class, 1)->create();

            factory(EntTypeName::class, 1)->create([
                'ent_type_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'                  => '1',
                'state'               => 'active',
                'transaction_type_id' => '3',
                'par_ent_type_id'     => NULL,
                'par_prop_type_val'   => NULL,
                't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [
                'id'                  => '2',
                'state'               => 'active',
                'transaction_type_id' => '3',
                'par_ent_type_id'     => NULL,
                'par_prop_type_val'   => NULL,
                't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [
                'id'                  => '3',
                'state'               => 'active',
                'transaction_type_id' => '3',
                'par_ent_type_id'     => NULL,
                'par_prop_type_val'   => NULL,
                't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [
                'id'                  => '4',
                'state'               => 'active',
                'transaction_type_id' => '3',
                'par_ent_type_id'     => NULL,
                'par_prop_type_val'   => NULL,
                't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],
            [
                'id'                  => '5',
                'state'               => 'active',
                'transaction_type_id' => '3',
                'par_ent_type_id'     => NULL,
                'par_prop_type_val'   => NULL,
                't_state_id'          => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ]
        ];

        foreach ($dados as $value) {
            EntType::create($value);
        }
    }
}
