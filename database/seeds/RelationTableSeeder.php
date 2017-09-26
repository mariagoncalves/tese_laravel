<?php

use Illuminate\Database\Seeder;
use App\Relation;
use App\RelationName;

class RelationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Relation::class, 6)->create()->each(function($new) {
            factory(RelationName::class, 1)->create([
                'relation_id' => $new->id, 
                'updated_by'  => $new->updated_by,
            ]);
        });
    }
}
