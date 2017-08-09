<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomForm extends Model
{
    protected $table = 'custom_form';

    public $timestamps = true;

    protected $fillable = [
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function properties() {
        return $this->belongsToMany('App\Property', 'custom_form_has_prop')->withPivot('field_order','mandatory_form','created_at','updated_at','deleted_at');
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
