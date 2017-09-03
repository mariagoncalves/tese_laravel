<?php

use Illuminate\Database\Seeder;
use App\Property;
use App\PropertyName;


class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [' Numero de Pessoas', 'Objetivo', 'Área', 'Preço', 'Quantidade'];

        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create();

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }
    }
}
