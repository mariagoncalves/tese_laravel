<?php

use Illuminate\Database\Seeder;
use App\RelTypeName;

class RelTypeNameTableSeeder extends Seeder
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
        		'rel_type_id' => '1',
        		'language_id' => '1',
        		'name'        => 'Pessoa pede transporte',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	]
        ];

        foreach ($dados as $value) {
            RelTypeName::create($value);
        }
    }
}
