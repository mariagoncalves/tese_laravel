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

        $newKey = 0;
        foreach ($entsRelated as $key => $value) {
            $ent_type_id = '';
            if ($value['ent_type1_id'] == $idEntType) {
                $ent_type_id = $value['ent_type2_id'];
            } else {
                $ent_type_id = $value['ent_type1_id'];
            }

            $properties = Property::with(['language' => function ($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->where('ent_type_id', $ent_type_id)
                            ->with('entType')
                            ->get()->toArray();

            foreach ($properties as $key1 => $value) {
                $properties[$key1]['key'] = $newKey;
                $newKey++;
            }

            $entsRelated[$key]['properties'] = $properties;
        }

        //\Log::debug($entsRelated);
        return response()->json($entsRelated);
    }

    public function viewDynamicSearch() {

        return view('dynamicSearchPresentation');
    }

    public function pesquisa (Request $request, $idEntityType) {
        $data = $request->all();
        \Log::debug($data);

        $frase = $this->formarFrase($idEntityType, $data);
        \Log::debug($frase);

        return response()->json($idEntityType);
    }

    public function formarFrase($idEntityType, $data) {
        $language_id = 1;
        $arrayVT = [];
        $arrayRL = [];
        $arrayER = [];

        $ent = EntType::with(['language' => function($query) use ($language_id) {
                        $query->where('language_id', $language_id);
                    }])->find($idEntityType);

        $frase[] = "Pesquisa de todas as entidades do tipo ".$ent->language->first()->pivot->name;

        // Formar a frase da tabela 1
        for ($i=0; $i < $data['numTableET']; $i++) { 
            if (isset($data['checkET'.$i])) {
                $this->formarFraseTipoTabela($data, $_REQUEST['checkET'.$i], 'ET', $i, $frase);
            }
        }

        // Formar a frase da tabela 2
        for ($i=0; $i < $data['numTableVT']; $i++) { 
            if (isset($data['checkVT'.$i])) {                
                $this->formarFraseTipoTabela($data, $data['checkVT'.$i], 'VT', $i, $frase);
            }
        }

        // Formar a frase da tabela 3
        for ($i=0; $i < $data['numTableRL']; $i++) { 
            if (isset($data['checkRL'.$i])) {                
                $this->formarFraseTipoTabela($data, $data['checkRL'.$i], 'RL', $i, $frase);
            }
        }

        // Formar a frase da tabela 4
        for ($i=0; $i < $data['numTableER']; $i++) { 
            if (isset($data['checkER'.$i])) {                
                $this->formarFraseTipoTabela($data, $data['checkER'.$i], 'ER', $i, $frase);
            }
        }

        return $frase;
    }

    public function formarFraseTipoTabela($data, $idProperty, $type, $position, &$frase) {
        $language_id = '1';

        $property = Property::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['entType' => function($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->with(['relType' => function($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->find($idProperty);

        $nomeProp  = $property->language->first()->pivot->name;
        $tipoValor = $property->value_type;

        if ($type == 'ET') {
            $auxFrase  = '- Propriedade '.$nomeProp.' é ';
        } elseif ($type == 'VT') {
            $nameEntidade = $property->entType->language->first()->pivot->name;
            $auxFrase = "- Referencie uma entidade do tipo ".$nameEntidade." cuja propriedade ".$nomeProp." é ";
        } else {
            $nameEntType1 = $this->getNameEntType($property->relType->ent_type1_id);
            $nameEntType2 = $this->getNameEntType($property->relType->ent_type2_id);

            if ($type == 'RL') {
                $auxFrase = "- Está presente na relação do tipo ".$nameEntType1." - ".$nameEntType2." cuja propriedade ".$nomeProp." é ";
            } else {
                $auxFrase = "- Têm uma relação com a entidade do tipo ".$nameEntType2." cuja propriedade ".$nomeProp." é ";
            }
        } 

        if ($tipoValor == "int") {
            $frase[] = $auxFrase . $data['operators'.$type.$position].' '.$data['int'.$type.$position].';';
        }  else if ($tipoValor == "double") {
            $frase[] = $auxFrase . $data['operators'.$type.$position].' '.$data['double'.$type.$position].';';
        } else  if ($tipoValor == "text") {
            $frase[] = $auxFrase . $data['text'.$type.$position].';';
        } else  if ($tipoValor == "enum") {  
            $frase[] = $auxFrase . $data['select'.$type.$position].';';
        } else  if ($tipoValor == "bool") {
            $frase[] = $auxFrase . $data['radio'.$type.$position].';';
        }
    }

    public function getNameEntType($idEntType) {
        $language_id = '1';

        $entType = EntType::with(['language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->find($idEntType);

        return $entType->language->first()->pivot->name;
    }

}
