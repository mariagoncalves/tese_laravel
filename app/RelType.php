<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelType extends Model
{
    use SoftDeletes;

    protected $table = 'rel_type';

    public $timestamps = true;

    protected $fillable = [
        'ent_type1_id',
        'ent_type2_id',
        't_state_id',
        'state',
        'transaction_type_id',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function tState() {

        return $this->belongsTo('App\TState', 't_state_id', 'id');
    }

    public function transactionsType() {
        return $this->belongsTo('App\TransactionType', 'transaction_type_id', 'id');
    }

    public function relations() {
        return $this->hasMany('App\Relation', 'rel_type_id', 'id');
    }

    public function properties() {
        return $this->hasMany('App\Property', 'rel_type_id', 'id');
    }

    public function ent1() {
        return $this->belongsTo('App\EntType', 'ent_type1_id', 'id');
    }

    public function ent2() {
        return $this->belongsTo('App\EntType', 'ent_type2_id', 'id');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'rel_type_name', 'rel_type_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function propertyReadRelType() {

        return $this->belongsToMany('App\Property', 'property_can_read_rel_type', 'providing_rel_type', 'reading_property')->withPivot('output_type','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
