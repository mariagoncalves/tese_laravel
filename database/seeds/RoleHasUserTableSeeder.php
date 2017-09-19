<?php

use Illuminate\Database\Seeder;
use App\RoleHasUser;

class RoleHasUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RoleHasUser::class, 2)->create();
    }
}
