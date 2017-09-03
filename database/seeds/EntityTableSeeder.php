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
        $datas = ['Transporte Crianças de escola', 'Apoio para concerto', 'Concurso Cidade Florida 2017'];

        foreach ($datas as $data) {
            $new = factory(Entity::class, 1)->create();

            factory(EntityName::class, 1)->create([
                'entity_id'   => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }
    }
}
