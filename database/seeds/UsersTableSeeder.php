<?php

use Illuminate\Database\Seeder;
use App\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Users::class, 1)->create(['name' => 'Maria', 'email' => 'maria@gmail.com']);

        factory(Users::class, 6)->create();
    }
}
