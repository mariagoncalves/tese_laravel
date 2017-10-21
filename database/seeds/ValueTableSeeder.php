<?php

use Illuminate\Database\Seeder;
use App\Value;
use App\ValueName;

class ValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(Value::class, 5)->create()->each(function($new) {
            factory(ValueName::class, 1)->create([
                'value_id'   => $new->id, 
                'updated_by' => $new->updated_by,
            ]);
        });*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'          => '1',
                'entity_id'   => '1',
                'property_id' => '1',
                'value'       => 'Transportação de crianças para o desporto escolar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '2',
                'entity_id'   => '1',
                'property_id' => '2',
                'value'       => 'Desporto escolar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '3',
                'entity_id'   => '1',
                'property_id' => '3',
                'value'       => '50',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
             [
                'id'          => '4',
                'entity_id'   => '1',
                'property_id' => '4',
                'value'       => 'Escola da levada',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '5',
                'entity_id'   => '2',
                'property_id' => '7',
                'value'       => 'Concerto Verão',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '6',
                'entity_id'   => '2',
                'property_id' => '8',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '7',
                'entity_id'   => '2',
                'property_id' => '9',
                'value'       => 'Pagar artistas',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '8',
                'entity_id'   => '2',
                'property_id' => '10',
                'value'       => '100',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '9',
                'entity_id'   => '2',
                'property_id' => '11',
                'value'       => 'True',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
             [
                'id'          => '10',
                'entity_id'   => '2',
                'property_id' => '12',
                'value'       => 'Social',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '11',
                'entity_id'   => '3',
                'property_id' => '5',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '12',
                'entity_id'   => '3',
                'property_id' => '6',
                'value'       => 'Hortas urbanas municipais',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '13',
                'entity_id'   => '4',
                'property_id' => '1',
                'value'       => 'Transporte para visita de estudo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '14',
                'entity_id'   => '4',
                'property_id' => '2',
                'value'       => 'Visita de estudo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '15',
                'entity_id'   => '4',
                'property_id' => '3',
                'value'       => '57',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '16',
                'entity_id'   => '4',
                'property_id' => '4',
                'value'       => 'Escola marítimo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '17',
                'entity_id'   => '5',
                'property_id' => '17',
                'value'       => '5327',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '18',
                'entity_id'   => '5',
                'property_id' => '18',
                'value'       => '650000',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '19',
                'entity_id'   => '6',
                'property_id' => '17',
                'value'       => '353',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '20',
                'entity_id'   => '6',
                'property_id' => '18',
                'value'       => '54533',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '21',
                'entity_id'   => '7',
                'property_id' => '17',
                'value'       => '54332',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '22',
                'entity_id'   => '7',
                'property_id' => '18',
                'value'       => '544333',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '23',
                'entity_id'   => '8',
                'property_id' => '13',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '24',
                'entity_id'   => '8',
                'property_id' => '14',
                'value'       => '123456789',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '25',
                'entity_id'   => '8',
                'property_id' => '15',
                'value'       => 'Programador',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '26',
                'entity_id'   => '8',
                'property_id' => '16',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '27',
                'entity_id'   => '9',
                'property_id' => '13',
                'value'       => 'Ines',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '28',
                'entity_id'   => '9',
                'property_id' => '14',
                'value'       => '123456788',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '29',
                'entity_id'   => '9',
                'property_id' => '15',
                'value'       => 'Medica',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '30',
                'entity_id'   => '9',
                'property_id' => '16',
                'value'       => 'Santo Antonio',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '31',
                'entity_id'   => '10',
                'property_id' => '13',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '32',
                'entity_id'   => '10',
                'property_id' => '14',
                'value'       => '123456799',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '33',
                'entity_id'   => '10',
                'property_id' => '15',
                'value'       => 'Estudante',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '34',
                'entity_id'   => '10',
                'property_id' => '16',
                'value'       => 'Santo da Serra',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '35',
                'entity_id'   => NULL,
                'property_id' => '19',
                'value'       => '18-08-2017',
                'relation_id' => '1',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '36',
                'entity_id'   => NULL,
                'property_id' => '19',
                'value'       => '01-09-2017',
                'relation_id' => '2',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '37',
                'entity_id'   => NULL,
                'property_id' => '19',
                'value'       => '01-09-2017',
                'relation_id' => '3',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '38',
                'entity_id'   => '11',
                'property_id' => '13',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '39',
                'entity_id'   => '11',
                'property_id' => '14',
                'value'       => '123451234',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '40',
                'entity_id'   => '11',
                'property_id' => '15',
                'value'       => 'Advogado',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '41',
                'entity_id'   => '11',
                'property_id' => '16',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]

        ];

        foreach ($dados as $value) {
            Value::create($value);
        }

    }
}
