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
        /*factory(Users::class, 1)->create(['name' => 'Maria', 'email' => 'maria@gmail.com']);

        factory(Users::class, 6)->create();*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'          => '1',           
                'name'        => 'Maria',
                'email'       => 'maria@gmail.com',
                'password'    => bcrypt('123456789'),
                'user_name'   => 'Mariajog',
                'language_id' => '1',
                'user_type'   => 'internal',
                'entity_id'   => NULL
            ],
            [
                'id'          => '2',           
                'name'        => 'Jose',
                'email'       => 'jose@gmail.com',
                'password'    => bcrypt('123456789'),
                'user_name'   => 'Jose',
                'language_id' => '1',
                'user_type'   => 'internal',
                'entity_id'   => NULL
            ]
        ];

        foreach ($dados as $value) {
            Users::create($value);
        }
    }
}
