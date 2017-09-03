<?php

use Illuminate\Database\Seeder;
use App\CustomForm;
use App\CustomFormName;

class CustomFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = ['Formulário de Cedência de Transporte', 'Formulário de Apoios', 'Formulário de Concursos'];

        foreach ($forms as $form) {
            $newForm = factory(CustomForm::class, 1)->create();

            factory(CustomFormName::class, 1)->create([
                'custom_form_id' => $newForm->id, 
                'name'           => $form,
                'language_id'    => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'     => $newForm->updated_by,
            ]);
        }

        factory(CustomForm::class, 10)->create()->each(function($newForm) {
            factory(CustomFormName::class, 1)->create([
                'custom_form_id' => $newForm->id, 
                'language_id'    => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'     => $newForm->updated_by,
            ]);
        });
    }
}
