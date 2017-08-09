<?php namespace App\Http\Controllers;

use App\Language;
use App\PropUnitType;
use App\PropUnitTypeName;
use Illuminate\Http\Request;
use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class PropUnitTypes extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('propUnitType');
    }

    /**
     * Buscar todos os prop_unit_type
     *
     * @return Response
     */
    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            $prop_unit_types = PropUnitType::with(['language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->paginate(5);

            return response()->json($prop_unit_types);
        }
        else
        {
            return $this->getSpec($id);
        }
    }


    public function getSpec($id)
    {
        $url_text = 'PT';

        $prop_unit_types = PropUnitType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);


        return response()->json($prop_unit_types);
    }

    /**
     * Inserir uma nova os unidade
     *
     * @return Response
     */
    public function insert(Request $request)
    {
		$createById = 1;
        $prop_unit_type = new PropUnitType;
        $prop_unit_type_name = new PropUnitTypeName;

        DB::beginTransaction();

        try {
            $prop_unit_type->state = $request->input('state');
			$prop_unit_type->updated_by = $createById;
            $prop_unit_type->save();

            $prop_unit_type_name->name = $request->input('name');
            $prop_unit_type_name->prop_unit_type_id = $prop_unit_type->id;
            $prop_unit_type_name->language_id = 1;
			$prop_unit_type_name->updated_by = $createById;
            $prop_unit_type_name->save();

            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $success = false;
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
		$query = ['prop_unit_type_id' => $id, 'language_id' => 1];
        $prop_unit_type_name = PropUnitTypeName::where($query);
        $prop_unit_type = PropUnitType::find($id);
		
		 try {
			 
            $query = ['prop_unit_type_id' => $id, 'language_id' => 1];
			$prop_unit_type_name = PropUnitTypeName::where($query);
			$prop_unit_type = PropUnitType::find($id);

			$prop_unit_type_name->update([
				'name' => $request->input('name')
			]);
			$prop_unit_type->update([
				'state' => $request->input('state')
			]);;

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }
}
