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
use App\RelType;
use Illuminate\Support\Facades\Log;

class PropertiesManagment extends Controller {

    public function index() {
        return view('property');
    }


    //MÉTODOS DAS ENTIDADES
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
            $entity_name     = $entity->language->first()->name;
            $ent             = substr($entity_name, 0 , 3);
            $dash            = '-';
            $field_name      = preg_replace('/[^a-z0-9_ ]/i', '', $data['property_name']);
            // Substituimos todos pos espaços por underscore
            $field_name      = str_replace(' ', '_', $field_name);
            $form_field_name = $ent.$dash.$data['entity_type'].$dash.$field_name;


            // inserir o nome da propriedade e o nome do campo form_field_name
            $data = [
                'property_id'     => $idNewProp,
                'language_id'     => 1,
                'name'            => $data['property_name'],
                'form_field_name' => $form_field_name
            ];
            PropertyName::create($data);

            return response()->json([]);
        } catch (\Exception $e) {
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

    //MÉTODOS DAS RELAÇÕES
    public function getAllPropertiesOfRelations() {

        return view('propertiesOfRelations');
    }

    public function getAllRel() {

        $language_id = '1';

        $rels = RelType::with(['properties.language' => function($query) use ($language_id) {
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


        return response()->json($rels);
    }

    public function getProperty($id) {
        $language_id = '1';

        $property = Property::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                            ->with(['units.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->find($id);

        return response()->json($property);
    }

    public function insertPropsRel(Request $request) {

        try {
            $data = $request->all();

            $propertyFieldSize = '';
            if(isset($data["property_fieldType_rel"])) {
                if ($data["property_fieldType_rel"] === "text") {
                    $propertyFieldSize = 'required|integer';
                } else if ($data["property_fieldType_rel"] === "textbox") {
                    $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
                }
            }

            $rulesFieldType = ['required'];

            if(isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'text') {
                //$rulesFieldType = 'required|regex:((text)|(textbox))';
                $rulesFieldType = ['required', Rule::in(['text','textbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'bool') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'enum') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'ent_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
            } else {
                $rulesFieldType = ['required', Rule::in(['text']),];
            }

            $rules = [
                'relation_type'           => ['required', 'integer'],
                'property_name_rel'       => ['required', 'string'],
                'property_valueType_rel'  => ['required'],
                'property_fieldType_rel'  => $rulesFieldType,
                'property_mandatory_rel'  => ['required'],
                /*'property_fieldOrder_rel' => ['required', 'integer', 'min:1'],*/
                'units_name'              => ['integer'],
                'property_fieldSize_rel'  => $propertyFieldSize,
                'property_state_rel'      => ['required'],
            ];


            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }

            if(!isset($data['units_name']) || (isset($data['units_name']) && $data['units_name'] == "0")) {
                $data['units_name'] = NULL;
            }

            //Buscar o nr de propriedades de uma relação, porque o form_field_size vai ser o nr de props que tem +1
            $countPropRel = Property::where('rel_type_id', '=', $data['relation_type'])->count();

            $data1 = array(
                'rel_type_id'      => $data['relation_type'          ],
                'value_type'       => $data['property_valueType_rel' ],
                'form_field_type'  => $data['property_fieldType_rel' ],
                'unit_type_id'     => $data['units_name'             ],
                /*'form_field_order' => $data['property_fieldOrder_rel'],*/
                'form_field_order' => $countPropRel + 1,
                'form_field_size'  => $data['property_fieldSize_rel' ],
                'mandatory'        => $data['property_mandatory_rel' ],
                'state'            => $data['property_state_rel'     ]
            );

            $newProp   = Property::create($data1);
            // pegar o id da nova propriedade inserida
            $idNewProp = $newProp->id;

            //Criar o form_field_name
            //Obter o nome da relação onde a propriedade vai ser inserida
            $relation        = RelType::find($data['relation_type']);
            $relationName    = $relation->language->first()->name;
            $rel             = substr($relationName, 0 , 3);
            $dash            = '-';
            $fieldName       = preg_replace('/[^a-z0-9_ ]/i', '', $data['property_name_rel']);
            // Substituimos todos pos espaços por underscore
            $fieldName       = str_replace(' ', '_', $fieldName);
            $form_field_name = $rel.$dash.$data['relation_type'].$dash.$fieldName;


            // inserir o nome da propriedade e o nome do campo form_field_name
            $data = [
                'property_id'     => $idNewProp,
                'language_id'     => 1,
                'name'            => $data['property_name_rel'],
                'form_field_name' => $form_field_name
            ];
            PropertyName::create($data);

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Try later.'], 500);
        }

    }

    public function updatePropsRel(Request $request, $id) {

        $data = $request->all();

        $propertyFieldSize = '';
        if(isset($data["property_fieldType_rel"])) {
            if ($data["property_fieldType_rel"] === "text") {
                $propertyFieldSize = 'required|integer';
            } else if ($data["property_fieldType_rel"] === "textbox") {
                $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
            }
        }

        $rulesFieldType = ['required'];

        if(isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'text') {
            //$rulesFieldType = 'required|regex:((text)|(textbox))';
            $rulesFieldType = ['required', Rule::in(['text','textbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'bool') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'enum') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'ent_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
        } else {
            $rulesFieldType = ['required', Rule::in(['text']),];
        }

        $rules = [
            'property_name_rel'       => ['required','string' , /*Rule::unique('property_name' , 'name')->where('language_id', '1')->ignore($id, 'property_id')*/],
            'property_state_rel'      => ['required'],
            'property_valueType_rel'  => ['required'],
            'property_fieldType_rel'  => ['required'],
            'property_mandatory_rel'  => ['required'],
            /*'property_fieldOrder_rel' => ['required', 'integer', 'min:1'],*/
            'units_name'              => ['integer'],
            'property_fieldSize_rel'  => $propertyFieldSize
        ];

        $err = Validator::make($data, $rules);
        // Verificar se existe algum erro.
        if ($err->fails()) {
            // Se existir, então retorna os erros
            $resultado = $err->errors()->messages();
            return response()->json(['error' => $resultado], 400);
        }

        if(!isset($data['units_name']) || (isset($data['units_name']) && $data['units_name'] == "0")) {
            $data['units_name'] = NULL;
        }

        $data1 = array(
            'value_type'       => $data['property_valueType_rel' ],
            'form_field_type'  => $data['property_fieldType_rel' ],
            'unit_type_id'     => $data['units_name'             ],
            /*'form_field_order' => $data['property_fieldOrder_rel'],*/
            'form_field_size'  => $data['property_fieldSize_rel' ],
            'mandatory'        => $data['property_mandatory_rel' ],
            'state'            => $data['property_state_rel'     ]
        );

        Property::where('id', $id)
                ->update($data1);


        $dataName = [
            'name' => $data['property_name_rel'],
        ];

        PropertyName::where('property_id', $id)
                    ->where('language_id', 1)
                    ->update($dataName);

        return response()->json([]);
    }

    //Métodos comuns
    public function getStates() {
        $states = Property::getValoresEnum('state');
        return response()->json($states);
    }

    public function getValueTypes() {
        $valueTypes = Property::getValoresEnum('value_type');
        return response()->json($valueTypes);
    }

    public function getFieldTypes() {
        $fieldTypes = Property::getValoresEnum('form_field_type');
        return response()->json($fieldTypes);
    }

    public function getUnits() {

        $language_id = '1';

        $units = PropUnitType::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->get();

        return response()->json($units);
    }


    //Métodos a serem usados no drag and drop
    public function getPropsRelations($id) {

        $language_id = '1';

        $propsRel = RelType::with(['properties.language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                            ->with(['properties' => function($query) {
                                    $query->orderBy('form_field_order', 'asc');
                                }])
                            ->find($id);

        return response()->json($propsRel);
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

    public function updateOrderProps(Request $request) {

        $content = $request->all();
        \Log::debug($content);

        if (is_array($content) && count($content) > 0) {
            foreach ($content as $key => $id) {
                Property::where('id', $id)->update(['form_field_order' => ($key + 1)]);
            }
        }

        return response()->json();
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
}
