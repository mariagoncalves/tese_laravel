<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomForm extends Model
{
    use SoftDeletes;

    protected $table = 'custom_form';

    public $timestamps = true;

    protected $fillable = [
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function ent_types() {
        return $this->belongsToMany('App\EntType', 'custom_form_has_ent_type' , 'custom_form_id', 'ent_type_id')->withPivot('field_order','mandatory_form','created_at','updated_at','deleted_at');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'custom_form_name', 'custom_form_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
