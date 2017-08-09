<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'language';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function propAllowedValue() {

    	return $this->belongsToMany('App\PropAllowedValue', 'prop_allowed_value_name');
    }

    public function propUnitType() {

    	return $this->belongsToMany('App\PropUnitType', 'prop_unit_type_name');
    }

    public function relation() {

    	return $this->belongsToMany('App\Relation', 'relation_name');
    }

    public function value() {

    	return $this->belongsToMany('App\Value', 'value_name');
    }

    public function property() {

    	return $this->belongsToMany('App\Property', 'property_name');
    }

    public function entType() {

    	return $this->belongsToMany('App\EntType', 'ent_type_name');
    }

    public function actor() {

    	return $this->belongsToMany('App\Actor', 'actor_name');
    }

    public function role() {

    	return $this->belongsToMany('App\Role', 'role_name');
    }

    public function processType() {
        return $this->belongsToMany('App\ProcessType', 'process_type_name');
    }

    public function process() {

    	return $this->belongsToMany('App\Process', 'process_name');
    }

    public function transactionType() {

    	return $this->belongsToMany('App\TransactionType', 'transaction_type_name');
    }

    public function tState() {

    	return $this->belongsToMany('App\TState', 't_state_name');
    }

    public function entity() {

    	return $this->belongsToMany('App\Entity', 'entity_name');
    }

    public function relType() {

    	return $this->belongsToMany('App\RelType', 'rel_type_name');
    }

    public function customForm() {

    	return $this->belongsToMany('App\CustomForm', 'custom_form_name');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
