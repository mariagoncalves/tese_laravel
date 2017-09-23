<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relation extends Model
{
    use SoftDeletes;

    protected $table = 'relation';

    public $timestamps = true;

    protected $fillable = [
        'rel_type_id',
        'entity1_id',
        'entity2_id',
        'transaction_state_id',
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function entity1() {
        return $this->belongsTo('App\Entity', 'entity1_id', 'id');
    }

    public function entity2() {
        return $this->belongsTo('App\Entity', 'entity2_id', 'id');
    }

    public function relType() {
        return $this->belongsTo('App\RelType', 'rel_type_id', 'id');
    }

    public function values() {
        return $this->hasMany('App\Value', 'relation_id', 'id');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'relation_name', 'relation_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
