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
        $dados = [
        	[
                'id'        => '1',
        		'name'      => 'Maria',
        		'email'     => 'maria@gmail.com',
        		'password'  => bcrypt('1234567'),
        		'user_name' => 'maria',
        		'language_id' => '1',
        		'user_type' => 'internal',
        		'entity_id' => '1',
        	],
        	[	
                'id'        => '2',
                'name'      => 'Jéssica',
        		'email'     => 'jessica@gmail.com',
        		'password'  => bcrypt('1234567'),
        		'user_name' => 'jessica',
        		'language_id' => '1',
        		'user_type' => 'internal',
        		'entity_id' => '1',
        	],
        	[	
                'id'        => '3',
                'name'      => 'José',
        		'email'     => 'jose@gmail.com',
        		'password'  => bcrypt('1234567'),
        		'user_name' => 'jose',
        		'language_id' => '1',
        		'user_type' => 'internal',
        		'entity_id' => '1',
        	]
        ];

        foreach ($dados as $value) {
            Users::create($value);
        }
    }
}
