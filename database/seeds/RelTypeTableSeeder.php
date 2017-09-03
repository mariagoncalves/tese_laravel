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
    }
}
