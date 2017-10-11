<?php

use Illuminate\Database\Seeder;
use App\RelType;
use App\RelTypeName;

class RelTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Relacao 1', 'Relacao 2', 'Relacao 3', 'Relacao 4'];

        foreach ($datas as $data) {
            $new = factory(RelType::class, 1)->create();

            factory(RelTypeName::class, 1)->create([
                'rel_type_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'entity_id'   => '1',
                'language_id' => '1',
                'name'        => 'Transporte Crianças de escola',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            RelType::create($value);
        }
    }
}
