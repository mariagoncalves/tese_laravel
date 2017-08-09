<?php

namespace App\Http\Controllers;

use App\Property;
use App\TransactionType;
use Illuminate\Http\Request;
use DB;
use Response;

class DashboardController extends Controller
{
    //
    public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            /*$firstTransactions = DB::table('transaction')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->join('role_has_actor', 'actor.id', '=', 'role_has_actor.actor_id')
                ->join('role', 'role.id', '=', 'role_has_actor.role_id')
                ->join('role_has_user', 'role.id', '=', 'role_has_user.role_id')
                ->join('users', 'users.id', '=', 'role_has_user.user_id')
                ->join('actor_iniciates_t', 'actor_iniciates_t.transaction_type_id', '=', 'transaction_type.id')
                ->join('actor as a1', 'a1.id', '=', 'actor_iniciates_t.actor_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.transaction_type_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.process_type_id', '=', 'l3.id')
                ->select('transaction.*','transaction_state.*')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('users.id','=',1)
                ->get();*/

            $firstTransactions = DB::table('transaction')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor_iniciates_t', 'actor_iniciates_t.transaction_type_id', '=', 'transaction_type.id')
                ->join('actor', 'actor.id', '=', 'actor_iniciates_t.actor_id')
                ->join('role_has_actor', 'actor.id', '=', 'role_has_actor.actor_id')
                ->join('role', 'role.id', '=', 'role_has_actor.role_id')
                ->join('role_has_user', 'role.id', '=', 'role_has_user.role_id')
                ->join('users', 'users.id', '=', 'role_has_user.user_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->select('transaction.*','transaction_state.*','t_state_name.*','transaction_type_name.*',DB::raw("'Iniciator' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('users.id','=',1);

            $secondTransactions = DB::table('transaction')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->join('role_has_actor', 'actor.id', '=', 'role_has_actor.actor_id')
                ->join('role', 'role.id', '=', 'role_has_actor.role_id')
                ->join('role_has_user', 'role.id', '=', 'role_has_user.role_id')
                ->join('users', 'users.id', '=', 'role_has_user.user_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->select('transaction.*','transaction_state.*','t_state_name.*','transaction_type_name.*',DB::raw("'Executer' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('users.id','=',1)
                ->union($firstTransactions)
                ->get();

            return response()->json($secondTransactions);

            //$user_id = 1;
            //return response()->json($this->getTransTypeUserCanInit($user_id));


            /*$url_text = 'PT';

            $matchThese = [];
            $orderThese = "";

            if ($request->has('s_id'))
            {
                $matchThese[] = array('t_state.id','=',$request->input('s_id'));
            }

            if ($request->has('s_name'))
            {
                $matchThese[] = array('t_state_name.name','LIKE','%'.$request->input('s_name').'%');
            }

            if ($request->has('input_sort'))
            {
                $orderThese = $request->input('input_sort') . ' ' . $request->input('type');
            }
            else
            {
                $orderThese = 't_state.id desc';
            }

            $tstates = DB::table('t_state')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->select('t_state.*', 't_state_name.name as t_state_name',
                    't_state_name.created_at as t_state_name_created_at',
                    't_state_name.updated_at as t_state_name_updated_at',
                    't_state_name.deleted_at as t_state_name_deleted_at'
                )
                ->where('l1.slug','=',$url_text)
                ->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(3);

            return response()->json($tstates);*/
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('dashboard');
    }

    public function insert(Request $request)
    {
        $tstate = new TState;
        $tstatename = new TStateName;

        DB::beginTransaction();
        try {
            $tstate->save();

            $tstatename->name = $request->input('name');
            $tstatename->language_id = $request->input('language_id');
            $tstatename->t_state_id = $tstate->id;
            $tstatename->save();

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
        $tstate = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $attributes = array(
                'name' => $request->input('name')
            );
            $tstate->language()->updateExistingPivot($id, $attributes);

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
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($tstates);
    }

    public function getTransTypeUserCanInit()
    {
        $user_id = 1;
        $url_text = 'PT';
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->get();

        return $transactions;
    }

    public function getProps($transtype_id)
    {
        $url_text = 'PT';

        $props = Property::with(['entType' => function ($query) use ($transtype_id) {
                $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id',NULL);
            }, 'entType.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propAllowedValues.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text)->orderBy('name', 'asc');
            }])->whereHas('entType', function ($query) use ($transtype_id) {
                return $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id',NULL);
        })->get();

        return response()->json($props);
    }

    public function getPropsfromChild($id)
    {
        $url_text = 'PT';

        $props = Property::with(['entType' => function ($query) use ($id) {
            $query->where('par_prop_type_val', $id);
        }, 'entType.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'propAllowedValues.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('entType', function ($query) use ($id) {
            return$query->where('par_prop_type_val', $id);
        })->get();

        return response()->json($props);
    }
}
