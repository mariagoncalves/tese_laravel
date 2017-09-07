<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntType;

class DynamicSearchController extends Controller
{
    public function index() {

        return view('dynamicSearch');
    }

    public function getEntities() {

    	$language_id = '1';

        $ents = EntType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])->get();

        return response()->json($ents);
    }

    //Testes
    /*public function getEntitiesData($id) {

    	$language_id = '1';

        $ents = EntType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])->find($id);

        return response()->json($ents);
    }*/

    public function getEntitiesDetails($id) {

    	\Log::debug($id);
    	return view('entitiesDetails', compact('id'));
    }
}
