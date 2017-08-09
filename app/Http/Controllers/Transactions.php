<?php

namespace App\Http\Controllers;

use App\TransactionType;
use Illuminate\Http\Request;
use App\Transaction;
use App\Process;
use DB;
use Response;

class Transactions extends Controller
{
    //
    //
    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';
            $transacs = Transaction::with(['process.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('transactionType.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);

            return response()->json($transacs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('transactions');
    }

    public function insert(Request $request)
    {
        $transaction = new Transaction;

        DB::beginTransaction();
        try {
            $transaction->state = $request->input('state');
            $transaction->process_id = $request->input('process_id');
            $transaction->transaction_type_id = $request->input('transaction_type_id');
            $transaction->save();

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

    }

    public function getSpec($id)
    {
        //return ProcessType::find($id);
        //$procs = ProcessType::with('language')->find($id);
        $url_text = 'PT';
        $transacs = Transaction::with(['process.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('transactionType.language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($transacs);
    }

    public function getAllProcesses()
    {
        $url_text = 'PT';
        $processes = Process::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('process_name.name','asc');
        })->get();

        return response()->json($processes);
    }

    public function getAllTransactionsTypes()
    {
        $url_text = 'PT';
        $transacs = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('transaction_type_name.t_name','asc');
        })->get();

        return response()->json($transacs);
    }
}
