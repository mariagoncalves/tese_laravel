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
    }
}
