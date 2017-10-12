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

        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'transaction_type_id' => '1',
                'actor_id'            => '1',
                'updated_by'          => '1',
                'deleted_by'          => NULL

        	]
        ];

        foreach ($dados as $value) {
            ActorIniciatesT::create($value);
        }
    }
}
