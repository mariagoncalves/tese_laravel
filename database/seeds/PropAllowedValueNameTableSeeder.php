<?php

use Illuminate\Database\Seeder;
use App\PropAllowedValueName;

class PropAllowedValueNameTableSeeder extends Seeder
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
        		'p_a_v_id'    => '1',
        		'language_id' => '1',
        		'name'        => 'Social',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'p_a_v_id'    => '2',
        		'language_id' => '1',
        		'name'        => 'Recreativa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'p_a_v_id'    => '3',
        		'language_id' => '1',
        		'name'        => 'Educativa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'p_a_v_id'    => '4',
        		'language_id' => '1',
        		'name'        => 'Desportiva',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'p_a_v_id'    => '5',
                'language_id' => '1',
                'name'        => 'Hortas urbanas municipais',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '6',
                'language_id' => '1',
                'name'        => 'Hortas urbanas sociais',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '7',
                'language_id' => '1',
                'name'        => 'Jardins de habitação social',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '8',
                'language_id' => '1',
                'name'        => 'Jardins unifamiliares',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '9',
                'language_id' => '1',
                'name'        => 'Varandas, balcões, terraços e escadarias',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '10',
                'language_id' => '1',
                'name'        => 'Unidades hoteleiras',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            PropAllowedValueName::create($value);
        }
    }
}
