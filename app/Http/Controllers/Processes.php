<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Process;
use App\ProcessType;
use App\ProcessName;
use App\Language;
use DB;
use Response;

class Processes extends Controller
{
    //
    public function getAll($id = null)
    {
        if ($id == null)
        {
            //$procs = ProcessType::orderBy('id','asc')->paginate(5);
            $url_text = 'PT';
            $procs = Process::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'processType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);

            //alternativa
            /*$lang = Language::where('slug','=','PT')->first();
            $process = $lang->process;
            $procstypes = $lang->processType;

            $procs = $process->where('process_type_id', $procstypes[0]->id);*/

            //$procs = Language::where('slug','=','PT')->with('processType')->paginate(5); quando é feito da linguagem para o processtypes

            /*$procs = Process::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'processType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->paginate(5);*/

            return response()->json($procs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('processes');
    }

    public function insert(Request $request)
    {
        $process = new Process;
        $processname = new ProcessName;

        /*$process->process_type_id = $request->input('process_type_id');
        $process->state = $request->input('state');

        $processname->language_id = $request->input('language_id');
        $processname->name = $request->input('name');
        DB::transaction(function() use ($process, $processname) {
            $process->save();

            $processname->process_id = $process->id;
            $processname->save();
        });*/

        DB::beginTransaction();
        try {
            $process->process_type_id = $request->input('process_type_id');
            $process->state = $request->input('state');

            $processname->language_id = $request->input('language_id');
            $processname->name = $request->input('name');

            $process->save();

            $processname->process_id = $process->id;
            $processname->save();

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

        //return 'Record successfully created with id ';
    }

    public function update(Request $request, $id)
    {
        $processtype = ProcessType::find($id);

        $processtype->name = $request->input('name');
        $processtype->state = $request->input('state');
        $processtype->save();
    }

    public function getSpec($id)
    {
        //return ProcessType::find($id);
        //$procs = ProcessType::with('language')->find($id);
        $url_text = 'PT';
        $procs = Process::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($procs);
    }

    public function getAllLanguage()
    {
        $langs = Language::orderBy('name','asc')->get();
        return response()->json($langs);
    }

    public function getAllProcsTypes()
    {
        $url_text = 'PT';
        $procs_types = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('process_type_name.name','asc');
        })->get();

        return response()->json($procs_types);
    }
}
