<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\PropUnitType;
use Illuminate\Support\Facades\Log;

class PropertiesController extends Controller {

    //Common methods of relations and entities
    public function getStates() {
        $states = Property::getValoresEnum('state');
        return response()->json($states);
    }

    public function getValueTypes() {
        $valueTypes = Property::getValoresEnum('value_type');
        return response()->json($valueTypes);
    }

    public function getFieldTypes() {
        $fieldTypes = Property::getValoresEnum('form_field_type');
        return response()->json($fieldTypes);
    }

    public function getUnits() {

        $language_id = '1';

        $units = PropUnitType::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                                ->whereHas('language', function ($query) use ($language_id){
                                    return $query->where('language_id', $language_id);
                                })->get();

        return response()->json($units);
    }

    public function getProperty($id) {
        $language_id = '1';

        $property = Property::with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }])
                            ->with(['units.language' => function($query) use ($language_id) {
                                $query->where('language_id', $language_id);
                            }])
                            ->with(['fkProperty' => function ($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->with(['readingEntTypes' => function ($query) use ($language_id) {
                               $query->with(['entType.language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->with(['propertyCanReadProperty' => function($query) use ($language_id) {
                                $query->with(['language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            /*->with(['readingEntTypes' => function($query) use ($language_id) {
                                $query->with(['entType.language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])
                            ->with(['propertyCanReadProperty' => function($query) use ($language_id) {
                                $query->with(['property.language' => function($query) use ($language_id) {
                                    $query->where('language_id', $language_id);
                                }]);
                            }])*/
                            ->find($id);

        return response()->json($property);

    }
}
