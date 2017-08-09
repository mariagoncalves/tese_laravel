<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TState extends Model
{
    protected $table = 't_state';

    public $timestamps = true;

    protected $fillable = [
		'updated_by',
        'deleted_by'
	];

    protected $guarded = [];

    public function stateCausalLink() {
        return $this->hasMany('App\CausalLink', 't_state_id', 'id');
    }

    public function waitedFact() {
        return $this->hasMany('App\WaitingLink', 'waited_fact', 'id');
    }

    public function waitingFact() {
        return $this->hasMany('App\WaitingLink', 'waiting_fact', 'id');
    }

    public function entType() {
        return $this->hasMany('App\EntType', 't_state_id', 'id');
    }

    public function transactionsState() {
        return $this->hasMany('App\TransactionState', 't_state_id', 'id');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 't_state_name', 't_state_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

}
