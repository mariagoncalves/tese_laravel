<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntType;
use App\PropAllowedValue;
use App\Property;
use App\RelType;

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

    public function getEntitiesDetails($id) {

    	//\Log::debug($id);
    	//return view('entitiesDetails', compact('id'));

    	$data = ['id' => $id];
    	return view('entitiesDetails')->with($data);
    }

    public function getEntitiesData($id) {

    	//\Log::debug($id);

    	$language_id = '1';

        $ents = EntType::with(['language' => function($query) use ($language_id)  {
        						$query->where('language_id', $language_id);
        					}])
        				->with(['properties' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
        				->with(['properties.language' => function($query) use ($language_id) {
        						$query->where('language_id', $language_id);
        					}])->find($id);

        //\Log::debug($ents);

        return response()->json($ents);
    }

    public function getOperators() {

        $operators = array(
            "lower"=>"<",
            "greater"=>">",
            "equal"=>"=",
            "different"=>"!="
            );

        return response()->json($operators);
   }

    public function getEnumValues($id) {

   		$language_id = '1';

        $propAllowedValues = PropAllowedValue::with(['language' => function ($query) use ($language_id) {
        											$query->where('language_id', $language_id);
        										}])
        									->where('prop_allowed_value.property_id', $id)
        									->get();

        //\Log::debug($propAllowedValues);

        return response()->json($propAllowedValues);
    }

    public function getEntityInstances($entId, $propId) {

        $language_id = '1';

        $fkEnt = Property::with(['fkEntType.entity.language' => function($query) use ($language_id) {
        						$query->where('language_id', $language_id);
        					}])
        					->where('ent_type_id' , $entId)
        					->where('value_type', 'ent_ref')
        				    ->where('id', $propId)
        				    ->get();

        //\Log::debug($fkEnt);

        return response()->json($fkEnt);
    }

    public function getEntRefs($id) {

        $language_id = '1';

        $entRefs = Property::with(['entType.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        /*->with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])*/
                        ->where('property.value_type', 'ent_ref')
                        ->where('property.fk_ent_type_id', $id)
                        ->get();

        //\Log::debug($entRefs);

        return response()->json($entRefs);
    }

    public function getPropsOfEnts($id) {

        $language_id = '1';

        $propsOfEnts = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->where('property.ent_type_id', $id)
                        ->where('property.value_type', '!=', 'ent_ref') //Evita a verificação na vista
                        ->get();

        //\Log::debug($propsOfEnts);

        return response()->json($propsOfEnts);
    }

    public function getRelsWithEnt($id) {

        $language_id = '1';

        $relsWithEnt = RelType::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['properties' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['properties.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['ent1.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->with(['ent2.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                        ->where('ent_type1_id', $id)
                        ->orWhere('ent_type2_id', $id)
                        ->get();

        //\Log::debug($relsWithEnt);

        return response()->json($relsWithEnt);
    }

    public function getEntsRelated($idRelType, $idEntType) {
        $language_id = '1';

        $entsRelated = RelType::where(function ($query) use ($idEntType) {
                                $query->where('ent_type1_id', $idEntType)->orWhere('ent_type2_id', $idEntType);
                            })
                            ->with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent1.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['ent2.language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->get()
                            ->toArray();

        foreach ($entsRelated as $key => $value) {
            $ent_type_id = '';
            if ($value['ent_type1_id'] == $idEntType) {
                $ent_type_id = $value['ent_type2_id'];
            } else {
                $ent_type_id = $value['ent_type1_id'];
            }

            $properteis = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('ent_type_id', $ent_type_id)
                            ->with('entType')
                            ->get();

            $entsRelated[$key]['properteis'] = $properteis->toArray();
        }

        //\Log::debug($entsRelated);
        return response()->json($entsRelated);
    }

    public function pesquisa ($id)  {

        //\Log::debug($id);

        //VARIAVEIS DE SESSAÕ ???
        if (isset($_SESSION['ER'])) {
            $numeroDechecksImpressos = $_SESSION['ER'];
        }
        else {
            $numeroDechecksImpressos = 0;
        }

        \Log::debug($numeroDechecksImpressos); //0

        // control variables count the number of checkboxes selected by type
        $checkSelected = 0;
        $checkSelectedET = 0;
        $checkSelectedVT = 0;
        $checkSelectedRL = 0;
        $checkSelectedER = 0;
        // arrays that retains the id of the refered entities, relations and related
        // entities wich properties where selected fo the search
        $arrayVT = array();
        $arrayRL = array();
        $arrayER = array();
        //control variables that indicates if any property of the entity or relation was already used
        $vtExiste = false;
        $relExiste = false;
        $i = 0;

        // cycles to count the number of checks selected by each category
        $erro = false;
        while( $i <=  $numeroDechecksImpressos) {
            if(isset($_REQUEST['checkET'.$i])) {
                //significa que foi selecionada
                $checkSelectedET++;
                $checkSelected++;
            }
            else if(isset($_REQUEST['checkVT'.$i])) {
                //significa que foi selecionada
                $checkSelectedVT++;
                $checkSelected++;
            }
            else if(isset($_REQUEST['checkRL'.$i])){
                //significa que foi selecionada
                $checkSelectedRL++;
                $checkSelected++;
            }
            else if(isset($_REQUEST['checkER'.$i])){
                //significa que foi selecionada
                $checkSelectedER++;
                $checkSelected++;
            }
            $i++;
        }

        //já tenho um método que me faz isso
        /*$language_id = '1';
        
        $ent = EntType::with(['language' => function ($query) use ($language_id){
            $query->where('language_id', $language_id);
        }])->where('id', $id);*/

        return response()->json($id);

    }
}
