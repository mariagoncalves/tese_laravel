<?php

use Illuminate\Database\Seeder;
use App\Actor;
use App\ActorName;

class ActorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Decisor sobre cedencia de transporte', 'Decisor sobre cedencia de apoios', 'Requerente de transporte'];

        foreach ($datas as $data) {
            $new = factory(Actor::class, 1)->create();

            factory(ActorName::class, 1)->create([
                'actor_id'    => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        factory(Actor::class, 2)->create()->each(function($new) {
            factory(ActorName::class, 1)->create([
                'actor_id'    => $new->id, 
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        });
    }
}
