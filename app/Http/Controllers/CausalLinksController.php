<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CausalLink;
use DB;
use Response;

class CausalLinksController extends Controller
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
                $matchThese[] = array('causal_link.id','=',$request->input('s_id'));
            }

            if ($request->has('s_causing_t'))
            {
                $matchThese[] = array('tpname1.t_name','LIKE','%'.$request->input('s_causing_t').'%');
            }

            if ($request->has('s_t_state'))
            {
                $matchThese[] = array('t_state.id','=',$request->input('s_t_state'));
            }

            if ($request->has('s_caused_t'))
            {
                $matchThese[] = array('tpname2.t_name','LIKE','%'.$request->input('s_caused_t').'%');
            }

            if ($request->has('input_sort'))
            {
                if ($request->input('input_sort') === 'tp1_causing_t')
                {
                    $orderThese = $request->input('input_sort') . ' ' . $request->input('type') . ',causal_link.t_state_id ' . $request->input('type');
                }
                else if ($request->input('input_sort') === 't_state_name')
                {
                    $orderThese = 'causal_link.causing_t ' . $request->input('type') .  ',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
                else
                {
                    $orderThese = 'causal_link.causing_t ' . $request->input('type') . ',causal_link.t_state_id ' . $request->input('type') .',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
            }
            else
            {
                $orderThese = 'causal_link.causing_t desc, causal_link.t_state_id desc';
            }

            $causallinks = DB::table('causal_link')
                ->join('transaction_type as tp1', 'tp1.id', '=', 'causal_link.causing_t')
                ->join('transaction_type_name as tpname1', 'tp1.id', '=', 'tpname1.transaction_type_id')
                ->join('transaction_type as tp2', 'tp2.id', '=', 'causal_link.caused_t')
                ->join('transaction_type_name as tpname2', 'tp2.id', '=', 'tpname2.transaction_type_id')
                ->join('t_state', 't_state.id', '=', 'causal_link.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('language as l1', 'tpname1.language_id', '=', 'l1.id')
                ->join('language as l2', 'tpname2.language_id', '=', 'l2.id')
                ->join('language as l3', 't_state_name.language_id', '=', 'l3.id')
                ->select('causal_link.*','tpname1.t_name as tp1_causing_t',
                    'tpname2.t_name as tp2_caused_t','t_state_name.name as t_state_name')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('causal_link.deleted_at','=',null)
                ->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(10);

            /*$causallinks = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'causedTransaction.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'tState.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('causingTransaction')->paginate(5);*/

            return response()->json($causallinks);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('CausalLinks');
    }

    public function insert(Request $request)
    {
        $causallink = new CausalLink;

        DB::beginTransaction();
        try {
            $causallink->causing_t = $request->input('causing_t');
            $causallink->t_state_id = $request->input('t_state_id');
            $causallink->caused_t = $request->input('caused_t');
            $causallink->min = $request->input('min');
            $causallink->max = $request->input('max');
            $causallink->save();

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
        $causallink = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        DB::beginTransaction();
        try {
            $causallink->causing_t = $request->input('causing_t');
            $causallink->t_state_id = $request->input('t_state_id');
            $causallink->caused_t = $request->input('caused_t');
            $causallink->min = $request->input('min');
            $causallink->max = $request->input('max');
            $causallink->save();

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
        $causallinks = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        DB::beginTransaction();
        try {
            $causallinks->delete();

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
        $causallinks = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        return response()->json($causallinks);
    }
}
