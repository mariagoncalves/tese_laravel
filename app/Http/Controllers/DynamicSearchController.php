<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntType;
use App\PropAllowedValue;
use App\Property;
use App\RelType;
use App\Entity;
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

        $operators = array(
            "lower"=>"<",
            "greater"=>">",
            "equal"=>"=",
            "different"=>"!="
            );

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

    /*public function viewDynamicSearch() {

        return view('dynamicSearchPresentation');
    }*/

    public function search(Request $request, $idEntityType) {
        $data        = $request->all();
        $language_id = '1';
        $result      = [];
        $query       = [];

        \Log::debug($data);
        /*\Log::debug("Id da propriedade");
        \Log::debug($data['checkET']);

        $query1 = $query1->whereHas('values', function($q) use ($operatorQuery, $valueQuery, $idProperty) {
            $q->where('value', $operatorQuery, $valueQuery)->where('property_id', $idProperty);
        }); */

        // Formar a query para apresentar os dados na tabela
        //Query base para a pesquisa
        $query = Entity::where('ent_type_id', $idEntityType)
                        ->with(['language' => function($query) use ($language_id) {
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

        $result['phrase'] = $phrase;
        $result['result'] = $query->get()->toArray();
        
        return response()->json($result);
    }

    public function formPhraseAndQuery($idEntityType, $data, &$query) {
        $language_id = 1;

        $ent = EntType::with(['language' => function($query) use ($language_id) {
                        $query->where('language_id', $language_id);
                    }])->find($idEntityType);

        $phrase[] = "Pesquisa de todas as entidades do tipo ".$ent->language->first()->pivot->name;

        // Formar a frase da tabela 1 e pesquisar de acordo com a pesquisa efetuada na tabela 1
        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $phrase = $this->formPhraseAndQueryTableType($data, $data['checkET'.$i], 'ET', $i, $phrase, $query);
            }
        }

        // Formar a frase da tabela 2
        for ($i=0; $i < $data['numTableVT']; $i++) { 
            if (isset($data['checkVT'.$i])) {                
                $phrase = $this->formPhraseAndQueryTableType($data, $data['checkVT'.$i], 'VT', $i, $phrase, $query);
            }
        }

        // Formar a frase da tabela 3
        for ($i=0; $i < $data['numTableRL']; $i++) { 
            if (isset($data['checkRL'.$i])) {

                $phrase = $this->formPhraseAndQueryTableType($data, $data['checkRL'.$i], 'RL', $i, $phrase, $query);
            }
        }

        // Formar a frase da tabela 4
        for ($i=0; $i < $data['numTableER']; $i++) { 
            if (isset($data['checkER'.$i])) {                
                $phrase = $this->formPhraseAndQueryTableType($data, $data['checkER'.$i], 'ER', $i, $phrase, $query);
            }
        }

        return $phrase;
    }

    public function formPhraseAndQueryTableType($data, $idProperty, $type, $position, $phrase, &$query1) {
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
            $query1 = $query1->whereHas('values', function($q) use ($operatorQuery, $valueQuery, $idProperty) {
                $q->where('value', $operatorQuery, $valueQuery)->where('property_id', $idProperty);
            }); 

        //}

        return $phrase;
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
