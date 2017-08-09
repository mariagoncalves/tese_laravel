<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'entity';

    public $timestamps = true;

    protected $fillable = [
        'ent_type_id',
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function entType() {
        return $this->belongsTo('App\EntType', 'ent_type_id', 'id');
    }

    public function values() {
        return $this->hasMany('App\Value', 'entity_id', 'id');
    }

    public function ent1Relations() {
        return $this->hasMany('App\Relation', 'entity1_id', 'id');
    }

    public function ent2Relations() {
        return $this->hasMany('App\Relation', 'entity2_id', 'id');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'entity_name', 'entity_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

    public function entityName() {
        return $this->hasMany('App\EntityName', 'entity_id', 'id');
    }

}
