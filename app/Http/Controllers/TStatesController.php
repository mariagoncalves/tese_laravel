<?php

namespace App\Http\Controllers;

use App\TState;
use App\TStateName;
use Illuminate\Http\Request;
use DB;
use Response;

class TStatesController extends Controller
{
    //
    public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

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

            return response()->json($tstates);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('tStates');
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
}
