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
use App\ActorCanReadProperty;
use App\ActorCanReadEntType;
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
            //\Log::debug($data);

            $propertyFieldSize = '';
            if(isset($data["property_fieldType"])) {
                if ($data["property_fieldType"] === "text") {
                    $propertyFieldSize = 'required|integer';
                } else if ($data["property_fieldType"] === "textbox") {
                    $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
                }
            }

            $rulesFieldType = ['required'];
            $rulesEntRef = ['integer'];
            $rulePropRef = ['integer'];
 
            $ruleEntTypeInfo = ['integer'];
            $rulePropInfo = ['integer'];

            //Remover o number por causa das validações
            if (isset($data['reference_entity']) && $data['reference_entity'] != '') {
                $data['reference_entity'] = str_replace('number:', '', $data['reference_entity']);
            }

            if(isset($data['property_valueType']) && $data['property_valueType'] == 'text') {
                //$rulesFieldType = 'required|regex:((text)|(textbox))';
                $rulesFieldType = ['required', Rule::in(['text','textbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'bool') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'enum') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'ent_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
                $rulesEntRef = ['required', 'integer'];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'prop_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
                $rulePropRef = ['required', 'integer'];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'file') {
                $rulesFieldType = ['required', Rule::in(['file']),];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'info') {
                $rulesFieldType = ['required', Rule::in(['text']),];
                $ruleEntTypeInfo = 'required_without_all:propselect';
                $rulePropInfo = 'required_without_all:ent_types_select';
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
                'reference_entity'         => $rulesEntRef,
                'fk_property'              => $rulePropRef,
                'ent_types_select'         => $ruleEntTypeInfo, //'required_without_all:propselect',
                'propselect'               =>  $rulePropInfo //'required_without_all:ent_types_select'
            ];

            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }

            if(!isset($data['unites_names']) || (isset($data['unites_names']) && $data['unites_names'] == "")) {
                $data['unites_names'] = NULL;
            }

            if(!isset($data['reference_entity']) || (isset($data['reference_entity']) && $data['reference_entity'] == "")) {
                $data['reference_entity'] = NULL;
            } 

            if(!isset($data['fk_property']) || (isset($data['fk_property']) && $data['fk_property'] == "")) {
                $data['fk_property'] = NULL;
            } 

            if(isset($data['property_valueType']) && $data['property_valueType'] == 'ent_ref') {
                $data['fk_property'     ] = NULL;
                $data['propselect'      ] = [];
                $data['ent_types_select'] = [];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'prop_ref') {
                $data['reference_entity'] = NULL;
                $data['propselect'      ] = [];
                $data['ent_types_select'] = [];
            } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'info') {
                $data['reference_entity'] = NULL;
                $data['fk_property'     ] = NULL;
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
                'fk_ent_type_id'   => $data['reference_entity'        ],
                'fk_property_id'   => $data['fk_property'             ],
                'can_edit'         => '1'
            );

            //\Log::debug($data1);

            $newProp   = Property::create($data1);
            // pegar o id da nova propriedade inserida
            $idNewProp = $newProp->id;

            //Criar o form_field_name
            //Obter o nome da relação onde a propriedade vai ser inserida
            $entity          = EntType::find($data['entity_type']);

            $entity_name     = $entity->language->first()->pivot->name;
            //\Log::debug($entity_name);
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

            // Adicionar propriedades na nova propriedade
            if(isset($data['propselect']) && $data['propselect']) {
                $propselect = explode(',', $data['propselect']);
                
                \Log::debug("Nova propriedade: " . $idNewProp);
                //\Log::debug("Associação das propriedades: ");

                foreach($propselect as $prop){
                    $prop_id = str_replace('number:', '', $prop);
                    
                    //Verificar se a propriedade já está associada com a nova propriedade
                    //$count = ActorCanReadProperty::where('property_need', $idNewProp)->where('property_info', $prop_id)
                      //                          ->get()->count();

                    //Se for igual a zero, significa que não está ainda associada..
                    //Logo será necessário associar

                    //if($count == 0) {
                        ActorCanReadProperty::create(['property_need' => $idNewProp, 'property_info' => $prop_id]);
                    //}
                }
            }

            //Adicionar entidades na nova propriedade
            if (isset($data['ent_types_select']) && $data['ent_types_select']) {
                $ent_types_select = explode(',', $data['ent_types_select']);

                //Percorrer cada uma das entidades e associar com a nova propriedade
                foreach ($ent_types_select as $enti) {
                    $enti_id = str_replace('number:', '', $enti);

                    //Verificar se a entidade já está associada com a nova propriedade
                    //$count = ActorCanReadEntType::where('property_need', $idNewProp)->where('ent_type_info', $enti_id)
                                                //->get()->count();

                    //Se for igual a zero, significa que não está ainda associada..
                    //Logo será necessário associar

                    //if ($count == 0) {
                        ActorCanReadEntType::create(['property_need' => $idNewProp, 'ent_type_info' => $enti_id]);
                    //}
                }
            }

            return response()->json([]);
        } catch (\Exception $e) {
            //\Log::debug("Métod: insertPropsEnt");
            //\Log::debug($e);
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
        $rulesEntRef = ['integer'];
        $rulePropRef = ['integer'];

        $ruleEntTypeInfo = ['integer'];
        $rulePropInfo = ['integer'];

       //Remover o number por causa das validações (tem de ser inteiro)
        if (isset($data['reference_entity']) && $data['reference_entity'] != '') {
            $data['reference_entity'] = str_replace('number:', '', $data['reference_entity']);
        }

        if(isset($data['property_valueType']) && $data['property_valueType'] == 'text') {
            //$rulesFieldType = 'required|regex:((text)|(textbox))';
            $rulesFieldType = ['required', Rule::in(['text','textbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'bool') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'enum') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'ent_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
            $rulesEntRef = ['required', 'integer'];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'prop_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
            $rulePropRef = ['required', 'integer'];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'file') {
            $rulesFieldType = ['required', Rule::in(['file']),];
        } else if (isset($data['property_valueType']) && $data['property_valueType'] == 'info') {
            $rulesFieldType = ['required', Rule::in(['text']),];
            $ruleEntTypeInfo = 'required_without_all:propselect';
            $rulePropInfo = 'required_without_all:ent_types_select';
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
            'reference_entity'    => $rulesEntRef,
            'fk_property'         => $rulePropRef,
            'ent_types_select'    => $ruleEntTypeInfo, //'required_without_all:propselect',
            'propselect'          => $rulePropInfo //'required_without_all:ent_types_select'

        ];

        $err = Validator::make($data, $rules);
        // Verificar se existe algum erro.
        if ($err->fails()) {
            // Se existir, então retorna os erros
            $resultado = $err->errors()->messages();
            return response()->json(['error' => $resultado], 400);
        }

        if(!isset($data['unites_names']) || (isset($data['unites_names']) && $data['unites_names'] == "")) {
            $data['unites_names'] = NULL;
        }

        if(!isset($data['reference_entity']) || (isset($data['reference_entity']) && $data['reference_entity'] == "")) {
            $data['reference_entity'] = NULL;
        } 

        if(!isset($data['fk_property']) || (isset($data['fk_property']) && $data['fk_property'] == "")) {
            $data['fk_property'] = NULL;
        }


        $data1 = array(
            'value_type'       => $data['property_valueType'      ],
            'form_field_type'  => $data['property_fieldType'      ],
            'unit_type_id'     => $data['unites_names'            ],
            //'form_field_order' => $data['property_fieldOrder'     ],
            'form_field_size'  => $data['property_fieldSize'      ],
            'mandatory'        => $data['property_mandatory'      ],
            'state'            => $data['property_state'          ],
            'fk_ent_type_id'   => $data['reference_entity'        ],
            'fk_property_id'   => $data['fk_property'             ],
            'can_edit'         => '1'
        );

        Property::where('id', $id)
                ->update($data1);

        $dataName = [
            'name' => $data['property_name'],
        ];

        PropertyName::where('property_id', $id)
                    ->where('language_id', 1)
                    ->update($dataName);



         ActorCanReadProperty::where('property_need', $id)->delete();
         ActorCanReadEntType::where('property_need', $id)->delete();

        // Editar propriedades na nova propriedade
        if(isset($data['propselect']) && $data['propselect']) {

            //ActorCanReadProperty::where('property_need', $id)->delete();

            $propselect = explode(',', $data['propselect']);

            \Log::debug($propselect);

           foreach($propselect as $prop){
                $prop_id = str_replace('number:', '', $prop);
                
                ActorCanReadProperty::create(['property_need' => $id, 'property_info' => $prop_id]);
            }
        }

        //Editar entidades na nova propriedade
         if(isset($data['ent_types_select']) && $data['ent_types_select']) {

            //ActorCanReadEntType::where('property_need', $id)->delete();

            $ent_types_select = explode(',', $data['ent_types_select']);

            \Log::debug($ent_types_select);

           foreach($ent_types_select as $entityType){
                $entityType_id = str_replace('number:', '', $entityType);
                
                ActorCanReadEntType::create(['property_need' => $id, 'ent_type_info' => $entityType_id]);
            }
        }

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
        //\Log::debug($dados);

        if (is_array($dados) && count($dados) > 0) {
            foreach ($dados as $key => $id) {
                Property::where('id', $id)->update(['form_field_order' => ($key + 1)]);
            }
        }

        return response()->json();
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

    public function getAllEnts() {

        $language_id = '1';

        $allEnts = EntType::with(['language' => function ($query) use ($language_id) {
                        $query->where('language_id', $language_id);
                    }])
                ->get();

        //\Log::debug($allEnts);

        return response()->json($allEnts);
    }
}
