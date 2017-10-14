<?php

use Illuminate\Database\Seeder;
use App\Entity;
use App\EntityName;

class EntityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = ['Transporte Crianças de escola', 'Apoio para concerto', 'Concurso Cidade Florida 2017'];

        foreach ($datas as $data) {
            $new = factory(Entity::class, 1)->create();

            factory(EntityName::class, 1)->create([
                'entity_id'   => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'                   => '1',
                'ent_type_id'          => '1',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '2',
                'ent_type_id'          => '3',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '3',
                'ent_type_id'          => '2',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '4',
                'ent_type_id'          => '1',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '5',
                'ent_type_id'          => '5',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '6',
                'ent_type_id'          => '5',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '7',
                'ent_type_id'          => '5',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '8',
                'ent_type_id'          => '4',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '9',
                'ent_type_id'          => '4',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [   'id'                   => '10',
                'ent_type_id'          => '4',
                'state'                => 'active',
                'transaction_state_id' => '1',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ]
        ];

        foreach ($dados as $value) {
            Entity::create($value);
        }
    }
}
