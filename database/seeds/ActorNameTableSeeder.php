<?php

use Illuminate\Database\Seeder;
use App\ActorName;

class ActorNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'actor_id'    => '1',
        		'language_id' => '1',
        		'name'        => 'Decisor sobre cedencia de transporte',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	'actor_id'    => '2',
        		'language_id' => '1',
        		'name'        => 'Decisor sobre cedencia de apoios',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'actor_id'    => '3',
        		'language_id' => '1',
        		'name'        => 'Requerente de transporte',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	]
        ];

        foreach ($dados as $value) {
            ActorName::create($value);
        }
    }
}
