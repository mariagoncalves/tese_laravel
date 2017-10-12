<?php

use Illuminate\Database\Seeder;
use App\RelationName;

class RelationNameTableSeeder extends Seeder
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
        		'relation_id' => '1',
                'language_id' => '1',
                'name'        => 'Munícipe 1235 pede transporte crianças escola',
                'updated_by'  => '1',
                'deleted_by'  => NULL

        	]
        ];

        foreach ($dados as $value) {
            RelationName::create($value);
        }
    }
}
