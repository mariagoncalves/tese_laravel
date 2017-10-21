<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntType;
use App\PropAllowedValue;
use App\Property;
use App\RelType;
use App\Entity;
use App\Value;
use App\Relation;

class DynamicSearchController extends Controller
{
    public function index() {

        return view('dynamicSearch');
    }

    public function getEntities() {

    	$language_id = '1';

        $ents = EntType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])->get();

        return response()->json($ents);
    }

    public function getEntitiesDetails($id) {

    	//\Log::debug($id);
    	//return view('entitiesDetails', compact('id'));

    	$data = ['id' => $id];
    	return view('entitiesDetails')->with($data);
    }

    public function getEntitiesData($id) {

    	//\Log::debug($id);

    	$language_id = '1';

        $ents = EntType::with(['language' => function($query) use ($language_id)  {
        						$query->where('language_id', $language_id);
        					}])
        				->with(['properties' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
        				->with(['properties.language' => function($query) use ($language_id) {
        						$query->where('language_id', $language_id);
        					}])->find($id);

        //\Log::debug($ents);

        return response()->json($ents);
    }

    public function getOperators() {

        /*$operators = array(
            "lower"=>"<",
            "greater"=>">",
            "equal"=>"=",
            "different"=>"!="
            );*/

        $operators = Property::getValoresEnum('operator_type', 'operator');

        return response()->json($operators);
   }

    public function getEnumValues($id) {

   		$language_id = '1';

        $propAllowedValues = PropAllowedValue::with(['language' => function ($query) use ($language_id) {
        											$query->where('language_id', $language_id);
        										}])
        									->where('prop_allowed_value.property_id', $id)
        									->get();

        //\Log::debug($propAllowedValues);

        return response()->json($propAllowedValues);
    }

    public function getEntityInstances($entId, $propId) {

        $language_id = '1';

        $fkEnt = Property::with(['fkEntType.entity.language' => function($query) use ($language_id) {
        						$query->where('language_id', $language_id);
        					}])
        					->where('ent_type_id' , $entId)
        					->where('value_type', 'ent_ref')
        				    ->where('id', $propId)
        				    ->get();

        //\Log::debug($fkEnt);

        return response()->json($fkEnt);
    }

    public function getEntRefs($idEntity) {

        $language_id = '1';

        $entRefs = Property::with(['entType.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('property.value_type', 'ent_ref')
                            ->where('property.fk_ent_type_id', $idEntity)
                            ->get()->toArray();

        $count        = 0;
        $dadosEntRefs = [];
        foreach ($entRefs as $entRef) {
            $dadosEntRef = $entRef;
            $dadosEntRef['properties'] = [];

            $propsOfEnts = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('ent_type_id', $entRef['ent_type_id'])
                            ->where('value_type', '!=', 'ent_ref') //Evita a verificação na vista
                            ->where('value_type', '!=', 'prop_ref')
                            ->get()->toArray();

            foreach ($propsOfEnts as $key => $prop) {
                $dadosProp = $prop;
                $dadosProp['key'] = $count;
                $dadosEntRef['properties'][] = $dadosProp;

                $count = $count + 1;
            }

            $dadosEntRefs[] = $dadosEntRef;
        }

        return response()->json($dadosEntRefs);
    }

    public function getPropsOfEnts($id) {

        /*$language_id = '1';

        $propsOfEnts = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->where('property.ent_type_id', $id)
                        ->where('property.value_type', '!=', 'ent_ref') //Evita a verificação na vista
                        ->get();

        return response()->json($propsOfEnts);*/
    }

    public function getRelsWithEnt($id) {

        $language_id = '1';

        $relsWithEnt = RelType::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['properties' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['properties.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['ent1.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['ent2.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->where(function($query) use ($id){
                            $query->where('ent_type1_id', $id)->orWhere('ent_type2_id', $id);
                        })
                        ->get()
                        ->toArray();

        $count = 0;
        foreach ($relsWithEnt as $key => $rel) {
            
            foreach ($rel['properties'] as $key1 => $prop) {
                $relsWithEnt[$key]['properties'][$key1]['key'] = $count;
                $count++;
            }
        }

        return response()->json($relsWithEnt);
    }

    public function getEntsRelated($idRelType, $idEntType) {
        $language_id = '1';

        $entsRelated = RelType::where(function ($query) use ($idEntType) {
                                $query->where('ent_type1_id', $idEntType)->orWhere('ent_type2_id', $idEntType);
                            })
                            ->with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent1.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent2.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->get()
                            ->toArray();    

        $newKey = 0;
        foreach ($entsRelated as $key => $value) {
            $ent_type_id = '';
            if ($value['ent_type1_id'] == $idEntType) {
                $ent_type_id = $value['ent_type2_id'];
            } else {
                $ent_type_id = $value['ent_type1_id'];
            }

            $properties = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('ent_type_id', $ent_type_id)
                            ->with('entType')
                            ->get()->toArray();

            foreach ($properties as $key1 => $value) {
                $properties[$key1]['key'] = $newKey;
                $newKey++;
            }

            $entsRelated[$key]['properties'] = $properties;
        }

        //\Log::debug($entsRelated);
        return response()->json($entsRelated);
    }

    public function search(Request $request, $idEntityType) {
        $data        = $request->all();
        $language_id = '1';
        $result      = [];
        $query       = [];

        //\Log::debug($data);
        /*\Log::debug("Id da propriedade");
        \Log::debug($data['checkET']);

        $query1 = $query1->whereHas('values', function($q) use ($operatorQuery, $valueQuery, $idProperty) {
            $q->where('value', $operatorQuery, $valueQuery)->where('property_id', $idProperty);
        }); */

        // Formar a query para apresentar os dados na tabela
        //Query base para a pesquisa
        $query = Entity::with(['language' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }])
                        ->with(['values' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }])
                        ->with(['values.language' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }])
                        ->with(['values.property.language' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }]);

        //Formar a frase e realizar pesquisa de acordo com a pesquisa..
        $phrase = $this->formPhraseAndQuery($idEntityType, $data, $query);

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (GERAL PESQUISA): ");
        \Log::debug($query->toSql());

        $result['phrase'] = $phrase;
        $result['result'] = $query->get()->toArray();
        
        return response()->json($result);
    }

    public function formPhraseAndQuery($idEntityType, $data, &$query) {
        $language_id = 1;

        $ent = EntType::with(['language' => function($q) use ($language_id) {
                        $q->where('language_id', $language_id);
                    }])->find($idEntityType);

        $phrase[] = "Pesquisa de todas as entidades do tipo ".$ent->language->first()->pivot->name;

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 1): ");

        // Formar a frase da tabela 1 e pesquisar de acordo com a pesquisa efetuada na tabela 1
        $selectTable1 = false;
        $queryTable1 = new Entity;
        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $selectTable1 = true;
                $phrase = $this->formPhraseTableType($data, $data['checkET'.$i], 'ET', $i, $phrase, $query);

                $this->formQueryTable1AndTable2($data, $data['checkET'.$i], 'ET', $i, $queryTable1);
            }
        }

        if ($selectTable1) {
            $resultTable1 = $queryTable1->distinct('id')->get(['id'])->toArray();

            $entitiesIdsTable1 = $this->formatArrayData($resultTable1, 'id');
            \Log::debug($entitiesIdsTable1);
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 2): ");

        // Formar a frase da tabela 2
        $selectTable2 = false;
        $queryTable2  = new Entity;
        for ($i = 0; $i < $data['numTableVT']; $i++) { 
            if (isset($data['checkVT'.$i])) {
                $selectTable2 = true;                
                $phrase = $this->formPhraseTableType($data, $data['checkVT'.$i], 'VT', $i, $phrase, $query);

                $this->formQueryTable1AndTable2($data, $data['checkVT'.$i], 'VT', $i, $queryTable2);
            }
        }

        if ($selectTable2) {

            $resultTable2 = $queryTable2->distinct('id')->get(['id'])->toArray();

            $entitiesIdsTable2 = $this->formatArrayData($resultTable2, 'id');
            \Log::debug($entitiesIdsTable2);

            foreach ($entitiesIdsTable2 as $key => $id_entity2) {
                $exist = false;

                foreach ($entitiesIdsTable1 as $id_entity) {
                    $nameE = Entity::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->find($id_entity);

                    $nameInstance = $nameE->language[0]->pivot->name;

                    //\Log::debug("NOMEEE DA ENTIDADEEEEEEEEEEEEEEEEEEEEEEE");
                    //\Log::debug($nameInstance);

                    $dataV = Value::where('entity_id', $id_entity2)
                                  ->where('value', $nameInstance)
                                  ->count();

                    if ($dataV > 0) {
                        $exist = true;
                        break;
                    }
                }

                if ($exist == false) {
                    unset($entitiesIdsTable2[$key]);
                }
            }
        } else if ($selectTable1) {
            // Adicionar a query geral filtros da tabela 1 
            $query = $query->where(function($q) use ($idEntityType, $entitiesIdsTable1) {
                    $q->where('ent_type_id', $idEntityType)->whereIn('id', $entitiesIdsTable1);
                });
        }

        if ($selectTable2 == true) {
            // Adicionar a query geral filtros da tabela 2 
            $query = $query->OrWhere(function($q) use ($idEntityType, $entitiesIdsTable2) {
                        $q->whereIn('id', $entitiesIdsTable2);
                    });
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 3): ");
        //Para a 3º tabela é suposto me aparecer as instancias das entidades pertencentes à relação

        $queryTable3 = new Relation;
        $selectTable3 = false;
        // Formar a frase da tabela 3
        for ($i=0; $i < $data['numTableRL']; $i++) { 
            if (isset($data['checkRL'.$i])) {
                $selectTable3 = true;
                $phrase = $this->formPhraseTableType($data, $data['checkRL'.$i], 'RL', $i, $phrase, $query);

                $this->formQueryTable1AndTable2($data, $data['checkRL'.$i], 'RL', $i, $queryTable3);
            }
        }

        if($selectTable3) {
            //Trazia todos os dados da relaçlão mas especifiquei que só quero o entity1_id e entity2_id
            $resultTable3 = $queryTable3->distinct('id')->get(['entity1_id', 'entity2_id'])->toArray();
            \Log::debug($resultTable3);

            $entitiesIdsTable3 = [];
            foreach ($resultTable3 as $key => $value) {
                //Para não meter valores repetidos no array
                if(!in_array($value['entity1_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = $value['entity1_id'];
                }

                if(!in_array($value['entity2_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = $value['entity2_id'];
                }
            }

            \Log::debug($entitiesIdsTable3);
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 4): ");

        $queryTable4 = new Entity;
        $selectTable4 = false;
        // Formar a frase da tabela 4
        for ($i=0; $i < $data['numTableER']; $i++) { 
            if (isset($data['checkER'.$i])) {  
                $selectTable4 = true;              
                $phrase = $this->formPhraseTableType($data, $data['checkER'.$i], 'ER', $i, $phrase, $query);

                $this->formQueryTable1AndTable2($data, $data['checkER'.$i], 'ER', $i, $queryTable4);
            }
        }

        if ($selectTable4) {

            //Trazia todos os dados da entidade mas especifiquei que só quero o id
            $resultTable4 = $queryTable4->distinct('id')->get(['id'])->toArray();
            //\Log::debug("RESULT TABELA 4");
            //\Log::debug($resultTable4);

            $entitiesIdsTable4 = $this->formatArrayData($resultTable4, 'id');
            \Log::debug($entitiesIdsTable4);

            foreach ($entitiesIdsTable4 as $key => $entitiesId) {
                if (!in_array($entitiesId, $entitiesIdsTable3)) {
                    unset($entitiesIdsTable4[$key]);
                }
            }

            \Log::debug("DEPOIS: ");
            \Log::debug($entitiesIdsTable4);

            // Adicionar a query geral filtros da tabela 4 
            //Busco as instancias dos ids que eu tenho no array
            $query = $query->OrWhere(function($q) use ($entitiesIdsTable4) {
                            $q->whereIn('id', $entitiesIdsTable4);
                        });

        } else if ($selectTable3) {
            //Percorro os ids das instancias de entidade e verifico se o ent_Type_id dessas instancias é = ao id da entidade que selecionei
            $aux = [];
            foreach ($entitiesIdsTable3 as $value) {
                
                $entTypeVal = Entity::where('id', $value)->first();

                if ($entTypeVal->ent_type_id == $idEntityType) {
                    $aux[] = $value;
                }
            }
            $entitiesIdsTable3 = $aux;

            // Adicionar a query geral filtros da tabela 3 
            //Busco as instancias dos ids que eu tenho no array
            $query = $query->OrWhere(function($q) use ($idEntityType, $entitiesIdsTable3) {
                            $q->whereIn('id', $entitiesIdsTable3);
                        });
        }

        return $phrase;
    }

    public function formPhraseTableType($data, $idProperty, $type, $position, $phrase, &$query1) {
        $property = $this->getPropertyData($idProperty);

        $nameProp  = $property->language->first()->pivot->name;
        $valueType = $property->value_type;

        if ($type == 'ET') {
            $auxPhrase  = '- Cuja propriedade '.$nameProp.' é ';
        } elseif ($type == 'VT') {
            $nameEntity = $property->entType->language->first()->pivot->name;
            $auxPhrase = "- Que referencie uma entidade do tipo ".$nameEntity." cuja propriedade ".$nameProp." é ";
        } else {
            if ($property->relType) {
                $nameEntType1 = $this->getNameEntType($property->relType->ent_type1_id);
                $nameEntType2 = $this->getNameEntType($property->relType->ent_type2_id);

                if ($type == 'RL') {
                    $auxPhrase = "- Que está presente na relação do tipo ".$nameEntType1." - ".$nameEntType2." cuja propriedade ".$nameProp." é ";

                } else {
                    $auxPhrase = "- Que tem uma relação com a entidade do tipo ".$nameEntType2." cuja propriedade ".$nameProp." é ";

                }
            } else {
                $auxPhrase  = '- Cuja propriedade '.$nameProp.' é ';
            }
        } 

        //Construir a frase conforme o value_type
        $valueQuery    = '';
        $operatorQuery = '=';
        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . $operatorQuery.' '.$valueQuery.';';
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . $operatorQuery.' '.$valueQuery.';';
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . $valueQuery.';';
        } else  if ($valueType == "enum") {
            $valueQuery = $data['select'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . $valueQuery.';';
        } else  if ($valueType == "bool") {
            $valueQuery = $data['radio'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . $valueQuery.';';
        }

        //if ($valueQuery != "") {

            // Adicionar a query filtros de pesquisa de acordo com as opções selecionadas
            /*$query1 = $query1->whereHas('values', function($q) use ($operatorQuery, $valueQuery, $idProperty) {
                                $q->where('property_id', $idProperty)->where('value', $operatorQuery, $valueQuery);
                            })->with(['values.property' => function($query) use ($valueQuery, $idProperty) {
                                $query->where('id', $idProperty);
                            }])->with(['values' => function($query) use ($valueQuery, $idProperty) {
                                $query->where('property_id', $idProperty);
                            }]);*/

        //}

        return $phrase;
    }

    public function formQueryTable1AndTable2($data, $idProperty, $type, $position, &$queryTable1) {
        $language_id = '1';

        $property  = $this->getPropertyData($idProperty);
        $valueType = $property->value_type;

        $valueQuery    = '';
        $operatorQuery = '=';
        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
        } else  if ($valueType == "enum") {
            $valueQuery = $data['select'.$type.$position];
        } else  if ($valueType == "bool") {
            $valueQuery = $data['radio'.$type.$position];
        }

        if($valueQuery == "") {
            if ($type == 'ET') {

                \Log::debug("TA A ENTRAR NA TABEL 1 ET");

                $valores = Value::where('property_id', $idProperty)->get(['entity_id', 'value'])->toArray();

                \Log::debug("VALORES DA QUERY");
                \Log::debug($valores);

                $saveIds = [];
                foreach ($valores as $key => $value) {
                    $saveIds[] = $value['entity_id'];
                }

                \Log::debug("RESULTADO DOS SAVEIDS");
                \Log::debug($saveIds);

                $queryTable1 = $queryTable1->OrWhere(function($q) use ($saveIds) {
                            $q->whereIn('id', $saveIds);
                        });

                \Log::debug("RESULTADO DA QUERY FINALLLL");
                \Log::debug($queryTable1->toSql());
            } else if ($type == 'VT') {

                //Mas nem tou a fazer nada e tá a funcionar???
                \Log::debug("TA A ENTRAR NA TABEL 2 VT");

            }
        } else {
            $queryTable1 = $queryTable1->whereHas('values', function($q) use ($idProperty, $operatorQuery, $valueQuery) {
                                        $q->where('property_id', $idProperty)->where('value', $operatorQuery, $valueQuery);
                                    });
        }

        /*$queryTable1 = $queryTable1->whereHas('values', function($q) use ($idProperty, $operatorQuery, $valueQuery) {
                                        $q->where('property_id', $idProperty)->where('value', $operatorQuery, $valueQuery);
                                    });*/
    }

    public function formatArrayData($data, $keySelect) {
        $array = [];
        foreach ($data as $value) {
            $array[] = $value[$keySelect];
        }

        return $array;
    }

    public function getPropertyData($idProperty) {
        $language_id = '1';

        $property = Property::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['entType' => function($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->with(['relType' => function($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->find($idProperty);

        return $property;
    }

    public function getNameEntType($idEntType) {
        $language_id = '1';

        $entType = EntType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->find($idEntType);

        return $entType->language->first()->pivot->name;
    }

    public function inactiveActive ($idEntity) {

        \Log::debug($idEntity);

        $stateEntity = Entity::where('id', $idEntity)->select(['state'])->first();
        \Log::debug($stateEntity->state);

        /*$stateEntity = Entity::where('id', $idEntity)->get();
        \Log::debug($stateEntity);
        $state = $stateEntity->first()->state;
        \Log::debug($state);*/

        if ($stateEntity->state == 'active') {

            //$data = ['state' => 'inactive'];

            Entity::where('id', $idEntity)
                    ->update(['state' => 'inactive']);

        } else {

           Entity::where('id', $idEntity)
                   ->update(['state' => 'active']);
        }

        return response()->json([$stateEntity->state]);
    } 

}
