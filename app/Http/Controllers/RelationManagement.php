<?php

namespace App\Http\Controllers;

//Bibliotecas para usar o validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use App\RelType;
use App\RelTypeName;
use App\EntType;
use App\TransactionType;
use App\TState;
use Illuminate\Http\Request;

use DB;

class RelationManagement extends Controller
{
    public function index() {

        return view('relTypes');
    }

    public function getAllRels() {

        $language_id = '1';

        $rels = RelType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent1.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent2.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['transactionsType.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['tState.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->whereHas('language', function ($query) use ($language_id){
                                return $query->where('language_id', $language_id);
                            })->paginate(5);

        return response()->json($rels);
    }

    public function getStates() {

        $states = RelType::getValoresEnum('state', 'property');
        return response()->json($states);
    }

    public function getEntities() {

        $language_id = '1';

        $entities = EntType::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->get();

        return response()->json($entities);
    }

    public function getTransactionTypes() {

        $language_id = '1';

        $transactionTypes = TransactionType::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->get();

        return response()->json($transactionTypes);
    }

    public function getTransactionStates() {

        $language_id = '1';

        $transactionStates = TState::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->get();

        return response()->json($transactionStates);
    }

    public function insertRelations(Request $request) {

       try {
            $data = $request->all();

            $rules = [
                'relation_name'     => ['required', 'string' ],
                'entity_type1'      => ['required', 'integer'],
                'entity_type2'      => ['required', 'integer', 'different:entity_type1'],
                'transactionsType'  => ['required', 'integer'],
                'transactionsState' => ['required', 'integer'],
                'relation_state'    => ['required']
            ];

            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }

            //Dados para inserir na tabela rel_Type
            $data1 = array(
                'ent_type1_id'         => $data['entity_type1'     ],
                'ent_type2_id'         => $data['entity_type2'     ],
                'state'                => $data['relation_state'   ],
                'transaction_type_id'  => $data['transactionsType' ],
                't_state_id'           => $data['transactionsState']
            );

            $newRelation = RelType::create($data1);
            $idNewRelation = $newRelation->id;

            //Dados para inserir na tabela rel_type_name
            $data = [
                'rel_type_id' => $idNewRelation,
                'language_id' => 1,
                'name' => $data['relation_name']
            ];

            RelTypeName::create($data);

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Try later.'], 500);
        }
    }

    public function getRelations($id) {

        $language_id = '1';

        $rel = RelType::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->find($id);

        return response()->json($rel);
    }

    public function updateRelationType(Request $request, $id) {

        $data = $request->all();

        $rules = [
            'relation_name'     => ['required', 'string', Rule::unique('rel_type_name', 'name')->where('language_id', '1')->ignore($id, 'rel_type_id')],
            'entity_type1'      => ['required', 'integer'],
            'entity_type2'      => ['required', 'integer', 'different:entity_type1'],
            'transactionsType'  => ['required', 'integer'],
            'transactionsState' => ['required', 'integer'],
            'relation_state'    => ['required']
        ];

        $err = Validator::make($data, $rules);
        // Verificar se existe algum erro.
        if ($err->fails()) {
            // Se existir, então retorna os erros
            $result = $err->errors()->messages();
            return response()->json(['error' => $result], 400);
        }

        $data1 = array(
            'ent_type1_id'         => $data['entity_type1'     ],
            'ent_type2_id'         => $data['entity_type2'     ],
            'state'                => $data['relation_state'   ],
            'transaction_type_id'  => $data['transactionsType' ],
            't_state_id'           => $data['transactionsState']
        );

        RelType::where('id', $id)
                ->update($data1);

        $dataName =  [
                'name' => $data['relation_name']
        ];

        RelTypeName::where('rel_type_id', $id)
                    ->where('language_id', 1)
                    ->update($dataName);

        return response()->json();
    }

    public function remove(Request $request, $id) {

        $relType = RelType::find($id)->delete();
        if ($relType) {
            $result = RelTypeName::where('rel_type_id', $id)->delete();
            if ($result) {
                return response()->json();
            }
        }

        return response()->json(['error' => 'An error occurred. Try later.'], 500);
    }

    public function getAll_test(Request $request, $id = null) {
        $data  = $request->all();
        $count = 5;
        // É de acordo com a váriavel 'count' que será apresentado o número de 'rel_types'.
        // Caso seja o 'count' 5, então será apresentado 5 'rel_types' na tabela.
        if (isset($data['count']) && $data['count'] != "") {
            $count = $data['count'];
        }

        // As váriaveis 'colSorting' e 'typeSorting' são utilizadas para ordenar os dados.
        // Por defeito, é ordenado pelo o 'created_at' e por ordem 'desc'.
        $colSorting  = 'created_at';
        $typeSorting = 'desc';
        if (isset($data['colSorting']) && $data['colSorting'] != "" && isset($data['typeSorting']) && $data['typeSorting'] != "") {
            $colSorting  = $data['colSorting'];
            $typeSorting = $data['typeSorting'];
        }

        $dataRelType = RelType::leftJoin('rel_type_name', function($query) {
                                    $query->on('rel_type.id', '=', 'rel_type_name.rel_type_id')->where('rel_type_name.language_id', 1);
                                })
                                ->leftJoin('ent_type_name AS ent1', function($query) {
                                    $query->on('rel_type.ent_type1_id', '=', 'ent1.ent_type_id')->where('ent1.language_id', 1);
                                })
                                ->leftJoin('ent_type_name AS ent2', function($query) {
                                    $query->on('rel_type.ent_type2_id', '=', 'ent2.ent_type_id')->where('ent2.language_id', 1);
                                })
                                ->leftJoin('t_state_name', function($query) {
                                    $query->on('rel_type.t_state_id', '=', 't_state_name.t_state_id')->where('t_state_name.language_id', 1);
                                })
                                ->leftJoin('transaction_type_name', function($query) {
                                    $query->on('rel_type.transaction_type_id', '=', 'transaction_type_name.transaction_type_id')
                                          ->where('transaction_type_name.language_id', 1);
                                })
                                // Este 'select' serve para selecionar quais os campos pretendidos de cada tabela.
                                // Por exemplo, da tabela 'rel_type' vem todos os campos.
                                // Já por sua vez, da tabela 'rel_type_name' só quero o campo 'name' e altero o nome para 'relation'.
                                ->select([
                                    'rel_type.*', 
                                    'rel_type_name.name AS relation', 
                                    'ent1.name AS entity1', 
                                    'ent2.name AS entity2', 
                                    't_state_name.name AS t_state_name',
                                    'transaction_type_name.t_name AS transaction_type'
                                ])
                                // Eu criei um scope 'scopeSearchRelTypes' em RelType.php para realizar a pesquisa e ficar mais organizados.
                                ->searchRelTypes($id, $data)
                                // Isto apenas é para ordenar os dados
                                ->orderBy($colSorting, $typeSorting)
                                ->paginate($count)
                                ->toArray();
                                
        \Log::debug($dataRelType);

        return response()->json($dataRelType);
    }
}
