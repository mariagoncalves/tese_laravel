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
use App\Query;
use App\Operator;
use App\Condicion;
use App\PropertyCanReadResult;

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

        //$operators = Property::getValoresEnum('operator_type', 'operator');
        //\Log::debug($operators);

        $dataOperators = Operator::all();
        //$dataOperators = Operator::select(['id', 'operator_type'])->get();

        \Log::debug("OPERADORESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS");
        \Log::debug($dataOperators);

        /*$operatorIds = [];
        foreach ($dataOperators as $key => $operator) {
            $operatorIds[] = $operator->id;
        }

        \Log::debug("IDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD  OPERADORESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS");
        \Log::debug($operatorIds);*/

        return response()->json($dataOperators);
        //return response()->json($operators);
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

    public function getPropRefs($idEntityType) {

        $propsId      = Property::where('ent_type_id', $idEntityType)->get(['id']);
        $arrayPropsId = [];
        foreach ($propsId as $propId) {
            $arrayPropsId[] = $propId->id;
        }

        \Log::debug("TESTEEEEEEEEEE 1");             
        \Log::debug($arrayPropsId);

        $language_id = '1';

        $propRefs = Property::with(['entType.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('property.value_type', 'prop_ref')
                            ->whereIn('property.fk_property_id', $arrayPropsId)
                            ->get()->toArray();

        \Log::debug("TESTEEEEEEEEEE 2");             
        \Log::debug($propRefs);

        $count        = 0;
        $dadosPropRefs = [];
        foreach ($propRefs as $entRef) {
            $dadosPropRef = $entRef;
            $dadosPropRef['properties'] = [];

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
                $dadosPropRef['properties'][] = $dadosProp;

                $count = $count + 1;
            }

            $dadosPropRefs[] = $dadosPropRef;
        }

        return response()->json($dadosPropRefs);
        //return response()->json($propRefs);
    }

    //public function getPropsOfEnts($id) {

        /*$language_id = '1';

        $propsOfEnts = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->where('property.ent_type_id', $id)
                        ->where('property.value_type', '!=', 'ent_ref') //Evita a verificação na vista
                        ->get();

        return response()->json($propsOfEnts);*/
    //}

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


    /*public function registarQueryPesquisa ($data, $idEntityType) {

        \Log::debug("NOMEEEEEEEEER QUERYYY");
        \Log::debug($data['query_name']);
         \Log::debug("iddddddddddddddddd  QUERYYY");
        \Log::debug($idEntityType);

        $data1 = array(
                'name'      => $data['query_name'],
                'ent_type_id' => $idEntityType
            );

        $dataQuery = Query::create($data1);
        $idQuery   = $dataQuery->id;

        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $this->createCondicion($idQuery, $data['checkET'.$i], 'ET', $i, $data);
            }
        }

    }*/

    public function createCondicion($idQuery, $idProperty, $type, $position, $data) {

        $property = $this->getPropertyData($idProperty);
        $valueType = $property->value_type;

        $idOperator = Operator::where('operator_type', '=')
                                ->select(['id'])
                                ->first();

        $valueQuery    = '';
        $operatorQuery = $idOperator->id;

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

        if($operatorQuery == "") {

            $operatorQuery = $idOperator->id;
        }

        $data1 = array(
            'query_id'    => $idQuery,
            'operator_id' => $operatorQuery,
            'property_id' => $idProperty,
            'table_type'  => $type,
            'value'       => $valueQuery,
        );

        $dataCondicion = Condicion::create($data1);

        $dataPropertyResult = array(
            'reading_property' => $idProperty,
            'providing_result' => $idQuery,
            'output_type'      => 'accordion',
            );

        $dataPropertyReadResult = PropertyCanReadResult::create($dataPropertyResult);

    }

    public function saveSearch (Request $request, $idEntityType) {

        \Log::debug("Tá a chegar ao método");
        $data = $request->all();
        \Log::debug("Teste ao salvar pesquisa");
        \Log::debug($data);

        $data1 = array(
                'name'      => $data['query_name'],
                'ent_type_id' => $idEntityType
            );

        $dataQuery = Query::create($data1);
        $idQuery   = $dataQuery->id;

        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $this->createCondicion($idQuery, $data['checkET'.$i], 'ET', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableVT']; $i++) { 
            if (isset($data['checkVT'.$i])) {
                $this->createCondicion($idQuery, $data['checkVT'.$i], 'VT', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableRL']; $i++) { 
            if (isset($data['checkRL'.$i])) {
                $this->createCondicion($idQuery, $data['checkRL'.$i], 'RL', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableER']; $i++) { 
            if (isset($data['checkER'.$i])) {
                $this->createCondicion($idQuery, $data['checkER'.$i], 'ER', $i, $data);
            }
        }
    }


    public function search(Request $request, $idEntityType) {
        $data        = $request->all();
        $generalData = [
            'table1' => ['select' => false, 'properties' => [], 'resultEntities' => [], 'relTable2' => [], 'relTable3' => [], 'relTable4' => []], 
            'table2' => ['select' => false, 'properties' => [], 'resultEntities' => []],
            'table3' => ['select' => false, 'properties' => [], 'resultRelation' => []],
            'table4' => ['select' => false, 'properties' => [], 'resultEntities' => []]
        ];
        $language_id = '1';
        $result      = [];
        $query       = [];

        /*if (isset($data['query_name']) && $data['query_name'] != "") {
            $this->registarQueryPesquisa($data, $idEntityType);
        }*/

        //Formar a frase e realizar pesquisa de acordo com a pesquisa..
        $phrase = $this->formPhraseAndQuery($idEntityType, $data, $generalData);
        $result['phrase'] = $phrase;

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (GERAL PESQUISA): ");

        $resultsTables['result1'] = [];
        if ($generalData['table1']['select']) {
            $resultsTables['result1'] = $this->getValuesEntitiesTables($generalData['table1']['properties'], $generalData['table1']['resultEntities']);
        }

        $resultsTables['result2'] = [];
        if ($generalData['table2']['select']) {
            $resultsTables['result2'] = $this->getValuesEntitiesTables($generalData['table2']['properties'], $generalData['table2']['resultEntities']);
        }

        $resultsTables['result3'] = [];
        if ($generalData['table3']['select']) {
            $resultsTables['result3'] = $this->getValuesRelationTables($generalData['table3']['properties'], $generalData['table3']['resultRelation']);
        }

        $resultsTables['result4'] = [];
        if ($generalData['table4']['select']) {
            $resultsTables['result4'] = $this->getValuesEntitiesTables($generalData['table4']['properties'], $generalData['table4']['resultEntities']);
        }

        \Log::debug($generalData);
        $result['result'] = $this->organizeDataTable($generalData, $resultsTables);

        return response()->json($result);
    }

    public function organizeDataTable($generalData, $resultsTables) {
        $resultFinal = [];
        if ($generalData['table1']['select'] && $generalData['table4']['select']) { // Tabela 1 e 4
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable4'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable4'][$entity['id']]) ? $generalData['table1']['relTable4'][$entity['id']] : [];
                foreach ($relations as $idRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as relacoes da tabela 4
                    foreach ($resultsTables['result4'] as $dataRelation) {
                        if ($dataRelation['id'] == $idRelation) {
                            // Cada value da relação da tabela 3
                            foreach ($dataRelation['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    $resultFinal[] = $valuesDataResult;
                }
            }
        } else if ($generalData['table1']['select'] && $generalData['table3']['select']) { // Tabela 1 e 3
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable3'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable3'][$entity['id']]) ? $generalData['table1']['relTable3'][$entity['id']] : [];
                foreach ($relations as $idRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as relacoes da tabela 3
                    foreach ($resultsTables['result3'] as $dataRelation) {
                        if ($dataRelation['id'] == $idRelation) {
                            // Cada value da relação da tabela 3
                            foreach ($dataRelation['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    $resultFinal[] = $valuesDataResult;
                }
            }
        } else if ($generalData['table1']['select'] && $generalData['table2']['select']) { // Tabela 1 e 2
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable2'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable2'][$entity['id']]) ? $generalData['table1']['relTable2'][$entity['id']] : [];
                foreach ($relations as $idEntityRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as entidades da tabela 2
                    foreach ($resultsTables['result2'] as $entity2) {
                        if ($entity2['id'] == $idEntityRelation) {
                            // Cada value da entidade da tabela 2
                            foreach ($entity2['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    $resultFinal[] = $valuesDataResult;
                }
            }
        } else if ($generalData['table1']['select']) { // Tabela 1
            // Percorrer as entidades
            foreach ($resultsTables['result1'] as $entity) {
                $valuesDataResult = [];
                // Cada value da entidade
                foreach ($entity['values'] as $valueData) {
                    $valuesDataResult[] = $valueData;
                }
                $resultFinal[] = $valuesDataResult;
            }
        }

        return $resultFinal;
    }

    public function getValuesEntitiesTables($properties, $entities) {
        $language_id = 1;
        $result = Entity::with('values')
                        ->with(['values.property.language' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }])
                        ->with(['values' => function($qu1) use ($properties) {
                            $qu1->whereIn('property_id', $properties);
                        }])->OrWhere(function($q3) use ($entities) {
                            $q3->whereIn('id', $entities);
                        })->get()->toArray();

        \Log::debug("RESULTADO METODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO");
        \Log::debug($result);
        return $result;
    }

    public function getValuesRelationTables($properties, $relations) {
        $language_id = 1;
        $result = Relation::with('values')
                        ->with(['values.property.language' => function($query) use ($language_id) {
                            $query->where('language_id', $language_id);
                        }])
                        ->with(['values' => function($qu1) use ($properties) {
                            $qu1->whereIn('property_id', $properties);
                        }])->OrWhere(function($q3) use ($relations) {
                            $q3->whereIn('id', $relations);
                        })->get()->toArray();

        return $result;
    }

    public function formPhraseAndQuery($idEntityType, $data, &$generalData) {
        $language_id = 1;

        $ent = EntType::with(['language' => function($q) use ($language_id) {
                        $q->where('language_id', $language_id);
                    }])->find($idEntityType);

        $phrase[] = "Pesquisa de todas as entidades do tipo ".$ent->language->first()->pivot->name;

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 1): ");

        // Formar a frase da tabela 1 e pesquisar de acordo com a pesquisa efetuada na tabela 1
        $queryTable1 = new Entity;
        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $generalData['table1']['select']       = true;
                $generalData['table1']['properties'][] = $data['checkET'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkET'.$i], 'ET', $i, $phrase);

                $this->formQueryTable($data, $data['checkET'.$i], 'ET', $i, $queryTable1);
            }
        }

        if ($generalData['table1']['select']) {
            $resultTable1 = $queryTable1->where('ent_type_id', $idEntityType)->distinct('id')->get(['id'])->toArray();
            $generalData['table1']['resultEntities'] = $this->formatArrayData($resultTable1, 'id');
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 2): ");

        // Formar a frase da tabela 2
        $queryTable2 = new Entity;
        for ($i = 0; $i < $data['numTableVT']; $i++) { 
            if (isset($data['checkVT'.$i])) {
                $generalData['table2']['select']       = true;
                $generalData['table2']['properties'][] = $data['checkVT'.$i];            
                $phrase = $this->formPhraseTableType($data, $data['checkVT'.$i], 'VT', $i, $phrase);

                $this->formQueryTable($data, $data['checkVT'.$i], 'VT', $i, $queryTable2);
            }
        }

        if ($generalData['table2']['select']) {
            $propertiesTable1 = $this->getPropertiesEntities($generalData['table1']['resultEntities']);

            $relacaoEntreTable1e2 = [];
            $resultTable2 = $queryTable2->distinct('id')->get(['id'])->toArray();

            $entitiesIdsTable2 = $this->formatArrayData($resultTable2, 'id');

            foreach ($entitiesIdsTable2 as $key => $id_entity2) {

                $values = Value::with('property')->where('entity_id', $id_entity2)->get();

                \Log::debug("VALORESSSSSS TESTEEEEEEEEEEEEEEEEEEE");
                \Log::debug($values);

                foreach ($values as $valueData) {
                    if (in_array($valueData->property->fk_property_id, $propertiesTable1)) {

                        foreach ($generalData['table1']['resultEntities'] as $id_entity1) {
                            $values = Value::where('entity_id', $id_entity1)
                                        ->where('value', $valueData->value)
                                        ->where('property_id', $valueData->property->fk_property_id)
                                        ->count();

                            if ($values > 0) {
                                $generalData['table1']['relTable2'][$id_entity1][] = $id_entity2;
                                $generalData['table2']['resultEntities'][] = $id_entity2;
                            }
                        }
                    }
                }
            }
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 3): ");

        $queryTable3 = new Relation;
        // Formar a frase da tabela 3
        for ($i=0; $i < $data['numTableRL']; $i++) { 
            if (isset($data['checkRL'.$i])) {
                $generalData['table3']['select'] = true;
                $generalData['table3']['properties'][] = $data['checkRL'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkRL'.$i], 'RL', $i, $phrase);

                $this->formQueryTable($data, $data['checkRL'.$i], 'RL', $i, $queryTable3);
            }
        }

        if ($generalData['table3']['select']) {
            //Trazia todos os dados da relaçlão mas especifiquei que só quero o entity1_id e entity2_id
            $resultTable3 = $queryTable3->distinct('id')->get(['id', 'entity1_id', 'entity2_id'])->toArray();

            $entitiesIdsTable3 = [];
            foreach ($resultTable3 as $key => $value) {
                $generalData['table3']['resultRelation'][] = $value['id'];
                //Para não meter valores repetidos no array
                if(!in_array($value['entity1_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = ['id_entity' => $value['entity1_id'], 'id_relation' => $value['id']];
                }

                if(!in_array($value['entity2_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = ['id_entity' => $value['entity2_id'], 'id_relation' => $value['id']];
                }
            }

            if ($generalData['table1']['select']) {
                $newIdsTable1 = [];
                foreach ($entitiesIdsTable3 as $dataRel) {
                    if (in_array($dataRel['id_entity'], $generalData['table1']['resultEntities'])) {
                        $newIdsTable1[] = $dataRel['id_entity'];
                        $generalData['table1']['relTable3'][$dataRel['id_entity']][] = $dataRel['id_relation'];
                    }
                }
                $generalData['table1']['resultEntities'] = $newIdsTable1;
            }
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 4): ");

        $queryTable4 = new Entity;
        // Formar a frase da tabela 4
        for ($i=0; $i < $data['numTableER']; $i++) { 
            if (isset($data['checkER'.$i])) {  
                $generalData['table4']['select'] = true;
                $generalData['table4']['properties'][] = $data['checkER'.$i];              
                $phrase = $this->formPhraseTableType($data, $data['checkER'.$i], 'ER', $i, $phrase);

                $this->formQueryTable($data, $data['checkER'.$i], 'ER', $i, $queryTable4);

                if (isset($data['idEntTypeER'.$i])) {
                    $queryTable4 = $queryTable4->where('ent_type_id', $data['idEntTypeER'.$i]);
                }
            }
        }

        if ($generalData['table4']['select']) {
            //\Log::debug($generalData['table1']['resultEntities']);
            //Trazia todos os dados da entidade mas especifiquei que só quero o id
            $resultTable4     = $queryTable4->distinct('id')->get(['id'])->toArray();
            $entitiesIdsTable4 = $this->formatArrayData($resultTable4, 'id');

            //\Log::debug("TESTEE FINAL 1122: ");
            //\Log::debug($entitiesIdsTable4);

            $newIdsTable1 = [];
            $newIdsTable4 = [];
            foreach ($generalData['table1']['resultEntities'] as $entity1) {

                foreach ($entitiesIdsTable4 as $entity2) {
                    $relation = Relation::where(function($qy) use ($entity1, $entity2) {
                                            $qy->where('entity1_id', $entity1)->where('entity2_id', $entity2);
                                        })->OrWhere(function($qy) use ($entity1, $entity2) {
                                            $qy->where('entity1_id', $entity2)->where('entity2_id', $entity1);
                                        })->first();

                    if ($relation) {
                        $newIdsTable1[] = $entity1;
                        if (isset($generalData['table1']['relTable4'][$entity1])) {
                            if (!in_array($relation->id, $generalData['table1']['relTable4'][$entity1])) {
                                $generalData['table1']['relTable4'][$entity1][] = $entity2;
                            }
                        } else {
                            $generalData['table1']['relTable4'][$entity1][] = $entity2;
                        }
                        $newIdsTable4[] = $entity2;
                    }
                }
            }
            $generalData['table1']['resultEntities'] = $newIdsTable1;
            $generalData['table4']['resultEntities'] = $newIdsTable4;
        }

        return $phrase;
    }

    public function formPhraseTableType($data, $idProperty, $type, $position, $phrase) {
        $property = $this->getPropertyData($idProperty);

        $nameProp  = $property->language->first()->pivot->name;
        $valueType = $property->value_type;

        if ($type == 'ET') {
            $auxPhrase  = '- Cujo valor para a propriedade '.$nameProp.' é ';
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

        if(isset($data['operators'.$type.$position]) && $data['operators'.$type.$position] != "" ) {

            $operatorSymbol = Operator::where('id', $data['operators'.$type.$position])
                                        ->select(['operator_type'])
                                        ->first();

            $operatorQuery = $operatorSymbol->operator_type;

        } else {
            $operatorQuery = '=';
        }

        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . ($valueQuery == '' ? 'qualquer' : $operatorQuery.' '.$valueQuery).';';
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . ($valueQuery == '' ? 'qualquer' : $operatorQuery.' '.$valueQuery) . ';';
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . ($valueQuery == '' ? 'qualquer' : $valueQuery).';';
        } else  if ($valueType == "enum") {
            $valueQuery = $data['select'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . ($valueQuery == '' ? 'qualquer' : $valueQuery).';';
        } else  if ($valueType == "bool") {
            $valueQuery = $data['radio'.$type.$position];
            // Formar a frase 
            $phrase[] = $auxPhrase . ($valueQuery == '' ? 'qualquer' : $valueQuery).';';
        }

        return $phrase;
    }

    public function formQueryTable($data, $idProperty, $type, $position, &$queryTable1) {
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

        if($valueQuery != "") {
            $queryTable1 = $queryTable1->whereHas('values', function($q) use ($idProperty, $operatorQuery, $valueQuery) {
                                        $q->where('property_id', $idProperty)->where('value', $operatorQuery, $valueQuery);
                                    });
        }
    }

    public function formatArrayData($data, $keySelect) {
        $array = [];
        foreach ($data as $value) {
            $array[] = $value[$keySelect];
        }

        return $array;
    }

    public function getPropertiesEntities($idsEntities = []) {
        $result = [];
        if (is_array($idsEntities) && count($idsEntities) > 0) {
            foreach ($idsEntities as $idEntity) {
                $properties = Value::where('entity_id', $idEntity)
                                    ->select(['property_id'])
                                    ->get();

                foreach ($properties as $property) {
                    if (!in_array($property->property_id, $result)) {
                        $result[] = $property->property_id;
                    }
                }
            }
        }

        return $result;
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

            Entity::where('id', $idEntity)
                    ->update(['state' => 'inactive']);
        } else {

           Entity::where('id', $idEntity)
                   ->update(['state' => 'active']);
        }

        return response()->json([$stateEntity->state]);
    } 

    public function showSavedSearches () {

        return view('showSavedSearches');
    }

    public function getSavedQueries () {

        $language_id = '1';

        $dataQuery = Query::with(['entType.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with('condicions')
                            ->with(['condicions.property.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with('condicions.operator')
                            ->get();

        \Log::debug($dataQuery);

        return response()->json($dataQuery);
    }
}
