<?php

use Illuminate\Database\Seeder;
use App\Process;
use App\ProcessName;

class ProcessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*$datas = ['Gestão nº1 a ocorrer', 'Gestão nº2 a ocorrer', 'Gestão nº3 a ocorrer'];

        foreach ($datas as $data) {
            $new = factory(Process::class, 1)->create();

            factory(ProcessName::class, 1)->create([
                'process_id'  => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        factory(Process::class, 2)->create()->each(function($new) {
            factory(ProcessName::class, 1)->create([
                'process_id'  => $new->id, 
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        });*/


        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'              => '1',           
                'process_type_id' => '1',
                'proc_state'      => 'execution',
                'state'           => 'active',
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ]
        ];

        foreach ($dados as $value) {
            Process::create($value);
        }
    }
}
