<?php

use Illuminate\Database\Seeder;
use App\RoleHasActor;

class RoleHasActorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RoleHasActor::class, 2)->create();
    }
}
