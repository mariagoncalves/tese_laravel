<?php

namespace App\Http\Controllers;

use App\TransactionTypeName;
use Illuminate\Http\Request;
use App\TransactionType;
use App\ProcessType;
use App\Actor;
use DB;
use Response;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionTypes extends Controller
{
    //
    public function getAll(Request $request, $id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';
            /*$transacs = TransactionType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'processType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'executerActor.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->orderBy('process_type_id','desc')->paginate(4);*/

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
                    $orderThese = $request->input('input_sort') . ' ' . $request->input('type');
                }
                else
                {
                    $orderThese = 'process_type.id ' . $request->input('type') .',' . $request->input('input_sort') . ' ' . $request->input('type');
                }
            }
            else
            {
                $orderThese = 'process_type.id desc';
            }

            $transacs = DB::table('transaction_type')
                ->join('process_type', 'transaction_type.process_type_id', '=', 'process_type.id')
                ->join('transaction_type_name', 'transaction_type.id', '=', 'transaction_type_name.transaction_type_id')
                ->join('language as l1', 'transaction_type_name.language_id', '=', 'l1.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l2', 'process_type_name.language_id', '=', 'l2.id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->join('actor_name', 'actor.id', '=', 'actor_name.actor_id')
                ->select('transaction_type_name.*','process_type_name.*','transaction_type.*','actor_name.name as executer')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(3);

            /*
            //Get current page form url e.g. &page=6
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            //Create a new Laravel collection from the array data
            $collection = $transacs;

            //Define how many items we want to be visible in each page
            $perPage = 3;

            //Slice the collection to get the items to display in current page
            $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)-> all();

            $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);*/


            /*$transacs = ProcessType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.executerActor.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(4);*/

            return response()->json($transacs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function getAll_test($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';
            $transacs = DB::table('transaction_type')
                ->join('process_type', 'transaction_type.process_type_id', '=', 'process_type.id')
                ->join('transaction_type_name', 'transaction_type.id', '=', 'transaction_type_name.transaction_type_id')
                ->join('language as l1', 'transaction_type_name.language_id', '=', 'l1.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l2', 'process_type_name.language_id', '=', 'l2.id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->select('transaction_type_name.*','process_type_name.*','transaction_type.*')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)
                ->orderBy('transaction_type.process_type_id','desc')->orderBy('transaction_type_name.rt_name','asc')
                ->get();
            //->paginate(4);

            /*$transacs = ProcessType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionsTypes.executerActor.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);*/

            return response()->json($transacs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('transactionTypes');
    }

    public function insert(Request $request)
    {
        $transactiontype = new TransactionType;
        $transactiontypename = new TransactionTypeName;

        DB::beginTransaction();
        try {
            $transactiontype->state = $request->input('state');
            $transactiontype->process_type_id = $request->input('process_type_id');
            $transactiontype->executer = $request->input('executer');
            $transactiontype->save();

            $transactiontypename->t_name = $request->input('t_name');
            $transactiontypename->rt_name = $request->input('rt_name');
            $transactiontypename->language_id = $request->input('language_id');
            $transactiontypename->transaction_type_id = $transactiontype->id;
            $transactiontypename->save();

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
        $transactiontype = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $transactiontype->state = $request->input('state');
            $transactiontype->process_type_id = $request->input('process_type_id');
            $transactiontype->executer = $request->input('executer');
            $transactiontype->save();

            $attributes = array(
                't_name' => $request->input('t_name'),
                'rt_name' => $request->input('rt_name')
            );
            $transactiontype->language()->updateExistingPivot($id, $attributes);

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
        $transactiontype = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $transactiontype->language()->detach($id);

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
        //return ProcessType::find($id);
        //$procs = ProcessType::with('language')->find($id);
        $url_text = 'PT';
        $transacs = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($transacs);
    }

    public function getAllExecuters()
    {
        $url_text = 'PT';
        $executers = Actor::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('actor_name.name','asc');
        })->get();

        return response()->json($executers);
    }
}
