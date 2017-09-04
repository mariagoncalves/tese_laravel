<?php

namespace App\Http\Controllers;

//Bibliotecas para usar o validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Illuminate\Http\Request;
use App\EntType;
use App\Property;
use App\PropertyName;
use App\PropUnitType;
use App\Language;
use Illuminate\Support\Facades\Log;

class PropertiesOfEntitiesController extends Controller {

    public function getAllPropertiesOfEntities() {

    	return view('propertiesOfEntities');
    }

    public function getAllEnt($id = null) {


        $language_id = '1';

        $ents = EntType::with(['properties.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['properties.units.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['properties' => function($query) {
                                $query->orderBy('form_field_order', 'asc');
                            }])->whereHas('language', function ($query) use ($language_id){
                                return $query->where('language_id', $language_id);
                            })->paginate(5);

        return response()->json($ents);
    }

    public function insertPropsEnt(Request $request) {
        try {
            $data = $request->all();

            $propertyFieldSize = '';
            if(isset($data["property_fieldType"])) {
                if ($data["property_fieldType"] === "text") {
                    $propertyFieldSize = 'required|integer';
                } else if ($data["property_fieldType"] === "textbox") {
                    $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
                }
            }

            $rulesFieldType = ['required'];

            if(isset($data['property_valueType']) && $data['property_valueType'] == 'text') {
                //$rulesFieldType = 'required|regex:((text)|(textbox))';
                $rulesFieldType = ['required', Rule::in(['text','textbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'bool') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'enum') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'ent_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
            } else {
                $rulesFieldType = ['required', Rule::in(['text']),];
            }

            $rules = [
                'entity_type'              => ['required', 'integer'],
                'property_name'            => ['required', 'string'/*, Rule::unique('property_name' , 'name')->where('language_id', '1')*/],
                'property_valueType'       => ['required'],
                'property_fieldType'       => $rulesFieldType,
                'property_mandatory'       => ['required'],
                //'property_fieldOrder'      => ['required', 'integer', 'min:1'],
                'unites_names'             => ['integer'],
                'property_fieldSize'       => $propertyFieldSize,
                'property_state'           => ['required'],
                'reference_entity'         => ['integer']
            ];

            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }

            if(!isset($data['unites_names']) || (isset($data['unites_names']) && $data['unites_names'] == "0")) {
                $data['unites_names'] = NULL;
            }

            if(!isset($data['reference_entity']) || (isset($data['reference_entity']) && $data['reference_entity'] == "0")) {
                $data['reference_entity'] = NULL;
            }

            //Buscar o nr de propriedades de uma relação, porque o form_field_order vai ser o nr de props que tem +1
            $countPropEnt = Property::where('ent_type_id', '=', $data['entity_type'])->count();

            $data1 = array(
                'ent_type_id'      => $data['entity_type'             ],
                'value_type'       => $data['property_valueType'      ],
                'form_field_type'  => $data['property_fieldType'      ],
                'unit_type_id'     => $data['unites_names'            ],
                //'form_field_order' => $data['property_fieldOrder'     ],
                'form_field_order' => $countPropEnt + 1,
                'form_field_size'  => $data['property_fieldSize'      ],
                'mandatory'        => $data['property_mandatory'      ],
                'state'            => $data['property_state'          ],
                'fk_ent_type_id'   => $data['reference_entity'        ]
            );

            $newProp   = Property::create($data1);
            // pegar o id da nova propriedade inserida
            $idNewProp = $newProp->id;

            //Criar o form_field_name
            //Obter o nome da relação onde a propriedade vai ser inserida
            $entity          = EntType::find($data['entity_type']);
            //$entity_name     = $entity->entTypeName->first()->name;
            $entity_name     = $entity->language->first()->pivot->name;
            \Log::debug($entity_name);
            //\Log::debug($entity_name);

            $ent             = substr($entity_name, 0 , 3);
            $dash            = '-';
            $field_name      = preg_replace('/[^a-z0-9_ ]/i', '', $data['property_name']);
            // Substituimos todos pos espaços por underscore
            $field_name      = str_replace(' ', '_', $field_name);
            $form_field_name = $ent.$dash.$data['entity_type'].$dash.$field_name;

            $dataProp = [
                'property_id'     => $idNewProp,
                'language_id'     => 1,
                'name'            => $data['property_name'],
                'form_field_name' => $form_field_name
            ];
            PropertyName::create($dataProp);

            return response()->json([]);
        } catch (\Exception $e) {
            \Log::debug("Métod: insertPropsEnt");
            \Log::debug($e);
            return response()->json(['error' => 'An error occurred. Try later.'], 500);
        }
    }

    public function updatePropsEnt(Request $request, $id) {

        $data = $request->all();

        $propertyFieldSize = '';
        if(isset($data["property_fieldType"])) {
            if ($data["property_fieldType"] === "text") {
                $propertyFieldSize = 'required|integer';
            } else if ($data["property_fieldType"] === "textbox") {
                $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
            }
        }

        $rulesFieldType = ['required'];

        if(isset($data['property_valueType']) && $data['property_valueType'] == 'text') {
            //$rulesFieldType = 'required|regex:((text)|(textbox))';
            $rulesFieldType = ['required', Rule::in(['text','textbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'bool') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'enum') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'ent_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
        } else {
            $rulesFieldType = ['required', Rule::in(['text']),];
        }

        $rules = [
            'property_name'       => ['required','string' , Rule::unique('property_name' , 'name')->where('language_id', '1')->ignore($id, 'property_id')],
            'property_state'      => ['required'],
            'property_valueType'  => ['required'],
            'property_fieldType'  => $rulesFieldType,
            'property_mandatory'  => ['required'],
            //'property_fieldOrder' => ['required', 'integer', 'min:1'],
            'unites_names'        => ['integer'],
            'property_fieldSize'  => $propertyFieldSize,
            'reference_entity'    => ['integer']

        ];

        $err = Validator::make($data, $rules);
        // Verificar se existe algum erro.
        if ($err->fails()) {
            // Se existir, então retorna os erros
            $resultado = $err->errors()->messages();
            return response()->json(['error' => $resultado], 400);
        }

        if(!isset($data['unites_names']) || (isset($data['unites_names']) && $data['unites_names'] == "0")) {
            $data['unites_names'] = NULL;
        }

        if(!isset($data['reference_entity']) || (isset($data['reference_entity']) && $data['reference_entity'] == "0")) {
            $data['reference_entity'] = NULL;
        }


        $data1 = array(
            'value_type'       => $data['property_valueType'      ],
            'form_field_type'  => $data['property_fieldType'      ],
            'unit_type_id'     => $data['unites_names'            ],
            //'form_field_order' => $data['property_fieldOrder'     ],
            'form_field_size'  => $data['property_fieldSize'      ],
            'mandatory'        => $data['property_mandatory'      ],
            'state'            => $data['property_state'          ],
            'fk_ent_type_id'   => $data['reference_entity'        ]
        );

        Property::where('id', $id)
                ->update($data1);

        $dataName = [
            'name' => $data['property_name'],
        ];

        PropertyName::where('property_id', $id)
                    ->where('language_id', 1)
                    ->update($dataName);


        return response()->json([]);
    }

    public function getPropsEntities($id) {

        $language_id = '1';

        $propsEnt = EntType::with(['properties.language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                            ->with(['properties' => function($query) {
                                    $query->orderBy('form_field_order', 'asc');
                                }])
                            ->find($id);

        return response()->json($propsEnt);
    }

    public function updateOrderPropsEnt(Request $request) {

        $dados = $request->all();
        \Log::debug($dados);

        if (is_array($dados) && count($dados) > 0) {
            foreach ($dados as $key => $id) {
                Property::where('id', $id)->update(['form_field_order' => ($key + 1)]);
            }
        }

        return response()->json();
    }

    public function getLanguages() {

        $language_id = '1';

        $languages = Language::all();

        return response()->json($languages);
    }

    public function remove(Request $request, $id) {

        $property = Property::find($id)->delete();
        if ($property) {
            $result = PropertyName::where('property_id', $id)->delete();
            if ($result) {
                return response()->json();
            }
        }

        return response()->json(['error' => 'An error occurred. Try later.'], 500);
    }
}
