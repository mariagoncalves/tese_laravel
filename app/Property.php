<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

     protected $table = 'property';

    public $timestamps = true;

    protected $fillable = [
        'ent_type_id',
        'rel_type_id',
        'value_type',
        'form_field_type',
        'unit_type_id',
        'form_field_order',
        'mandatory',
        'state',
        'fk_ent_type_id',
        'fk_property_id',
        'form_field_size',
        'can_edit',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function entType() {
        return $this->belongsTo('App\EntType', 'ent_type_id', 'id');
    }

    public function fkEntType() {
        return $this->belongsTo('App\EntType', 'fk_ent_type_id', 'id');
    }

    public function fkProperty() {
        return $this->belongsTo('App\Property', 'fk_property_id', 'id');
    }

    /*public function customForms() {
        return $this->belongsToMany('App\CustomForm', 'custom_form_has_prop');
    }*/

    public function relType() {
        return $this->belongsTo('App\RelType', 'rel_type_id', 'id');
    }

    public function values() {
        return $this->hasMany('App\Value', 'property_id', 'id');
    }

    public function units() {
        return $this->belongsTo('App\PropUnitType', 'unit_type_id', 'id');
    }

    public function propAllowedValues() {
        return $this->hasMany('App\PropAllowedValue', 'property_id', 'id');
    }

    public function readingEntTypes() {
        return $this->belongsToMany('App\EntType', 'property_can_read_ent_type', 'reading_property', 'providing_ent_type')->withPivot('output_type', 'created_at','updated_at','deleted_at');
    }

    public function propertyCanReadProperty () {
        return $this->belongsToMany('App\Property', 'property_can_read_property', 'reading_property', 'providing_property')->withPivot('created_at','updated_at','deleted_at');
    }

    public function propertiesProviding() {
        return $this->belongsToMany('App\Property', 'property_can_read_property', 'providing_property', 'reading_property')->withPivot('created_at','updated_at','deleted_at');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'property_name', 'property_id', 'language_id')->withPivot('name','form_field_name','created_at','updated_at','deleted_at');
    }

    public function queries() {

        return $this->belongToMany('App\Query', 'property_can_read_result', 'reading_property', 'providing_result')->withPivot('output_type','created_at','updated_at','deleted_at');
    }

    public function condicions() {

        return $this->hasMany('App\Condicion', 'property_id', 'id');
    }

    public function relTypes() {

        return $this->belongsToMany('App\RelType', 'property_can_read_rel_type', 'reading_property', 'providing_rel_type')->withPivot('output_type','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

    //$name é o nome do campo do qual quero obter os valores enum
    public static function getValoresEnum($name, $table){
        $type = DB::select(DB::raw('SHOW COLUMNS FROM '.$table.' WHERE Field = "'.$name.'"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }

}
