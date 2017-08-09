<?php

namespace App\Http\Controllers;

use App\Language;
use DB;
use Illuminate\Http\Request;
use Response;


class LanguageController extends Controller{

    public function index()
    {
        return view('languages');
    }

    public function getAll($id = null)
    {
        if ($id == null) {
            $languages = Language::paginate(5);

            foreach ($languages as $language) {
                if ($language->updated_at) {
                    $language->updated_on = $language->updated_at->format('d M Y');
                } else {
                    $language->updated_on = "Undefined";
                }
            }
            return response()->json($languages);
        }else{
            return $this->getSpec($id);
        }
    }

    public function getSpec($id)
    {
        $languages = Language::where('id',$id)->first();

        return response()->json($languages);
    }

    public function insert(Request $request)
    {
        $language = new Language;

        DB::beginTransaction();

        try {
            $language->name = $request->input('name');
            $language->slug = $request->input('slug');
            $language->state = $request->input('state');
            if (auth()->user()) {
                $language->updated_by = auth()->user()->id;
            }else{
                $language->updated_by = 1;
            }
            $language->save();


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

    }

    public function update(Request $request, $id)
    {
        $language = Language::find($id);
        $language->update([
            'name' => $request->input('name')
        ]);
        $language->update([
            'slug' => $request->input('slug')
        ]);
        $language->update([
            'state' => $request->input('state')
        ]);
        if (auth()->user()) {
        $language->update([
            'updated_by' => auth()->user()->id
        ]);
        }
    }


    public function remove(Request $request, $id)
    {
        $language = Language::find($id)->delete();
    }

}
