<?php

use Illuminate\Database\Seeder;
use App\ActorIniciatesT;

class ActorIniciatesTTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ActorIniciatesT::class, 2)->create();
    }
}
