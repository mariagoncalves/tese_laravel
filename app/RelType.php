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
        'id',
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

    public function scopeSearchRelTypes($query, $id, $data) {
        if ($id != null) {
            $query->where('id', $id);
        }

        if (isset($data['relation']) && $data['relation'] != '') {
            $query->where('rel_type_name.name', 'LIKE', '%'.$data['relation'].'%');
        }

        if (isset($data['entity1']) && $data['entity1'] != '') {
            $query->where('ent1.name', 'LIKE', '%'.$data['entity1'].'%');
        }

        if (isset($data['entity2']) && $data['entity2'] != '') {
            $query->where('ent2.name', 'LIKE', '%'.$data['entity2'].'%');
        }

        if (isset($data['transType']) && $data['transType'] != '') {
            $query->where('transaction_type_name.t_name', 'LIKE', '%'.$data['transType'].'%');
        }

        if (isset($data['transState']) && $data['transState'] != '') {
            $query->where('t_state_name.name', 'LIKE', '%'.$data['transState'].'%');
        }

        if (isset($data['state']) && $data['state'] != '') {
            $query->where('rel_type.state', 'LIKE', '%'.$data['state'].'%');
        }
    }

    public function scopeSearchPropsRel($query, $id, $data) {
        if ($id != null) {
            $query->where('id', $id);
        }

        if (isset($data['relation']) && $data['relation'] != '') {
            $query->where('rel_type_name.name', 'LIKE', '%'.$data['relation'].'%');
        }

        if (isset($data['property']) && $data['property'] != '') {
            $query->where('property_name.name', 'LIKE', '%'.$data['property'].'%');
        }
    }
}
