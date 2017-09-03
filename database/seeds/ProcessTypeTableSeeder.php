<?php

use Illuminate\Database\Seeder;
use App\ProcessType;
use App\ProcessTypeName;

class ProcessTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $processes = [
            ['Gestão de Transportes', 'Transport Management'], 
            ['Gestão de Concursos',   'Contests Management'], 
            ['Gestão de Apoios',      'Support Management']
        ];

        foreach ($processes as $process) {
            $newProcess = factory(ProcessType::class, 1)->create();

            factory(ProcessTypeName::class, 1)->create([
                'process_type_id' => $newProcess->id, 
                'name'            => $process[0],
                'language_id'     => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'      => $newProcess->updated_by,
            ]);

            factory(ProcessTypeName::class, 1)->create([
                'process_type_id' => $newProcess->id, 
                'name'            => $process[1],
                'language_id'     => App\Language::where('slug', 'en')->first()->id,
                'updated_by'      => $newProcess->updated_by,
            ]);
        }
    }
}
