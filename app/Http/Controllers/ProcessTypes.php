<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValProcType;
use App\ProcessType;
use App\ProcessTypeName;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use DB;
use File;

class ProcessTypes extends Controller
{
    //

    public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            //$procs = ProcessType::with('language')->orderBy('id','asc')->paginate(5);
            $url_text = 'PT';
            /*$procs = ProcessType::with('language')->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(2);*/

            /*$procs = ProcessType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text,$request){
                    return $query->where('slug', $url_text);
            })->paginate(2);*/

            //$procs = Language::where('slug','=','PT')->with('processType')->paginate(5); quando é feito da linguagem para o processtypes

            /*if ($request1->has('s')) {
                $s =
                return $query->where('t_name','LIKE','%'. $s . '%')->where('slug', $url_text);
            }*/

            $matchThese = [];
            $orderThese = "";
            if ($request->has('s_id'))
            {
                $matchThese[] = array('process_type.id','=',$request->input('s_id'));
            }

            if ($request->has('s_name'))
            {
                $matchThese[] = array('process_type_name.name','LIKE','%'.$request->input('s_name').'%');
            }

            if ($request->has('s_state'))
            {
                $matchThese[] = array('process_type.state','LIKE',$request->input('s_state'));
            }


            if ($request->has('input_sort'))
            {
                $orderThese = $request->input('input_sort') . ' ' . $request->input('type');
            }
            else
            {
                $orderThese = 'process_type.id asc';
            }

            $procs = DB::table('process_type')
                ->join('process_type_name', 'process_type.id', '=', 'process_type_name.process_type_id')
                ->join('language as l1', 'process_type_name.language_id', '=', 'l1.id')
                ->select('process_type.*','process_type_name.*')
                ->where('l1.slug','=',$url_text)->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(2);

            return response()->json($procs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('processTypes');
    }

    public function insert(ValProcType $request)
    {
        $processtype = new ProcessType;
        $processtypename = new ProcessTypeName;

        DB::beginTransaction();
        try {
            $processtype->state = $request->input('state');

            $processtypename->name = $request->input('name');
            $processtypename->language_id = $request->input('language_id');

            $processtype->save();

            $processtypename->process_type_id = $processtype->id;
            $processtypename->save();

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
        $processtype = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $processtype->state = $request->input('state');
            $processtype->save();

            $attributes = array(
                'name' => $request->input('name')
            );
            $processtype->language()->updateExistingPivot($id, $attributes);

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
        $processtype = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $processtype->language()->detach();

            //$processtype->language()->updateExistingPivot($id,  ['deleted_at' => DB::raw('NOW()')]);

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
        $procs = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        return response()->json($procs);
    }

    public function getAllLanguage()
    {
        $langs = Language::orderBy('name','asc')->get();
        return response()->json($langs);
    }
}
