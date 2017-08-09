<?php

namespace App\Http\Controllers;

use App\EntType;
use App\TransactionType;
use App\TState;
use App\EntTypeName;
use App\ProcessType;
use Illuminate\Http\Request;
use DB;
use Response;

class EntTypes extends Controller
{
    //
    public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';


            $matchThese = [];
            $orderThese = "";
            if ($request->has('s_process_type'))
            {
                $matchThese[] = array('process_type_name.name','LIKE','%'.$request->input('s_process_type').'%');
            }

            if ($request->has('s_id'))
            {
                $matchThese[] = array('transaction_type.id','=',$request->input('s_id'));
            }

            if ($request->has('s_name'))
            {
                $matchThese[] = array('transaction_type_name.t_name','LIKE','%'.$request->input('s_name').'%');
            }

            if ($request->has('s_result_type'))
            {
                $matchThese[] = array('transaction_type_name.rt_name','LIKE','%'.$request->input('s_result_type').'%');
            }

            if ($request->has('s_state'))
            {
                $matchThese[] = array('process_type.state','=',$request->input('s_state'));
            }

            if ($request->has('s_executer'))
            {
                $matchThese[] = array('actor_name.name','LIKE','%'.$request->input('s_executer').'%');
            }

            if ($request->has('s_process_type'))
            {
                $matchThese[] = array('process_type_name.name','LIKE','%'.$request->input('s_process_type').'%');
            }

            if ($request->has('input_sort'))
            {
                if ($request->input('input_sort') === 'process_type_name.name')
                {
                    $orderThese = 'transaction_type.id ' . $request->input('type') .  ',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
                else if ($request->input('input_sort') === 'transaction_type_name.t_name')
                {
                    $orderThese = 'process_type.id ' . $request->input('type') . ',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
                else
                {
                    $orderThese = 'process_type.id ' . $request->input('type') . ', transaction_type.id ' . $request->input('type') . ',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
            }
            else
            {
                $orderThese = 'process_type.id desc, transaction_type.id desc';
            }

            $ents = DB::table('ent_type')
                ->join('ent_type_name', 'ent_type.id', '=', 'ent_type_name.ent_type_id')
                ->join('transaction_type','transaction_type.id','=','ent_type.transaction_type_id')
                ->join('transaction_type_name','transaction_type.id','=','transaction_type_name.transaction_type_id')
                ->join('process_type','process_type.id','=','transaction_type.process_type_id')
                ->join('process_type_name','process_type.id','=','process_type_name.process_type_id')
                ->join('t_state','ent_type.t_state_id','=','t_state.id')
                ->join('t_state_name','t_state.id','=','t_state_name.t_state_id')
                ->join('language as l1', 'ent_type_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l2.id')
                ->select('ent_type.*', 'ent_type_name.name as ent_type_name','process_type_name.name as process_type_name',
                    'process_type.id as process_type_id',
                    'transaction_type_name.t_name as transaction_type_t_name',
                    't_state_name.name as t_state_name')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(3);

            /*$ents = EntType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'tStates.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'entType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->orderBy('transaction_type_id','desc')->paginate(3);*/

            /*$ents = ProcessType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.entType.tStates.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.entType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('transactionsTypes.entType.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);*/

            /*$ents = TransactionType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'entType.tStates.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'entType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('entType.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);*/

            return response()->json($ents);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('entTypes');
    }

    public function insert(Request $request)
    {
        $entitytype = new EntType;
        $entitytypename = new EntTypeName;

        DB::beginTransaction();
        try {
            $entitytype->state = $request->input('state');
            $entitytype->transaction_type_id = $request->input('transaction_type_id');

            if ($request->input('ent_type_id') != "")
            {
                $entitytype->ent_type_id = $request->input('ent_type_id');
            }

            $entitytype->t_state_id = $request->input('t_state_id');
            $entitytype->save();

            $entitytypename->name = $request->input('name');
            $entitytypename->language_id = $request->input('language_id');
            $entitytypename->ent_type_id = $entitytype->id;
            $entitytypename->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }

        $returnData = array(
            'message' => 'An error occurred!'
        );

        if ($success) {
            return Response::json(null,200);
        }
        else
        {
            return Response::json($returnData, 400);
        }
    }

    public function update(Request $request, $id)
    {
        $url_text = 'PT';
        $entitytype = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tStates.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $entitytype->state = $request->input('state');
            $entitytype->transaction_type_id = $request->input('transaction_type_id');

            if ($request->input('ent_type_id') != "")
            {
                $entitytype->ent_type_id = $request->input('ent_type_id');
            }

            $entitytype->t_state_id = $request->input('t_state_id');
            $entitytype->save();

            $attributes = array(
                'name' => $request->input('name')
            );
            $entitytype->language()->updateExistingPivot($id, $attributes);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }

        $returnData = array(
            'message' => 'An error occurred!'
        );

        if ($success) {
            return Response::json(null,200);
        }
        else
        {
            return Response::json($returnData, 400);
        }
    }

    public function delete(Request $request, $id)
    {
        $url_text = 'PT';
        $entitytype = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tStates.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $entitytype->language()->detach($id);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }

        $returnData = array(
            'message' => 'An error occurred!'
        );

        if ($success) {
            return Response::json(null,200);
        }
        else
        {
            return Response::json($returnData, 400);
        }
    }

    public function getSpec($id)
    {
        $url_text = 'PT';
        $ents = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tStates.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($ents);
    }

    public function getAllTransactionTypes()
    {
        $url_text = 'PT';
        $transactiontypes = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('transaction_type_name.t_name','asc');
        })->get();

        return response()->json($transactiontypes);
    }

    public function getAllTStates()
    {
        $url_text = 'PT';
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('t_state_name.name','asc');
        })->get();

        return response()->json($tstates);
    }

    public function getAllEntTypes()
    {
        $url_text = 'PT';
        $enttypes = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('ent_type_name.name','asc');
        })->get();

        return response()->json($enttypes);
    }
}
