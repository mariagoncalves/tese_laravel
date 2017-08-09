<?php

namespace App\Http\Controllers;

use App\WaitingLink;
use Illuminate\Http\Request;
use DB;
use Response;

class WaitingLinksController extends Controller
{
    //
    //
    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';
            $waitinglinks = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitingTransaction.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitingFact.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitedFact.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('waitedT.language')->paginate(5);

            return response()->json($waitinglinks);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('WaitingLinks');
    }

    public function insert(Request $request)
    {
        $waitinglink = new WaitingLink;

        DB::beginTransaction();
        try {
            $waitinglink->waited_t = $request->input('waited_t');
            $waitinglink->waited_fact = $request->input('waited_fact');
            $waitinglink->waiting_fact = $request->input('waiting_fact');
            $waitinglink->waiting_transaction = $request->input('waiting_transaction');
            $waitinglink->min = $request->input('min');
            $waitinglink->max = $request->input('max');
            $waitinglink->save();

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
        $waitinglink = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        DB::beginTransaction();
        try {
            $waitinglink->waited_t = $request->input('waited_t');
            $waitinglink->waited_fact = $request->input('waited_fact');
            $waitinglink->waiting_fact = $request->input('waiting_fact');
            $waitinglink->waiting_transaction = $request->input('waiting_transaction');
            $waitinglink->min = $request->input('min');
            $waitinglink->max = $request->input('max');
            $waitinglink->save();

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
        $waitinglink = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        DB::beginTransaction();
        try {
            $waitinglink->delete();

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
        $waitinglinks = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        return response()->json($waitinglinks);
    }
}
