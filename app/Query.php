<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Query extends Model
{
    use SoftDeletes;

    protected $table = 'query';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'ent_type_id',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function condicions() {

        return $this->hasMany('App\Condicion', 'query_id', 'id');
    }

    public function properties() {

        return $this->belongToMany('App\Property', 'property_can_read_result', 'providing_result', 'reading_property')->withPivot('output_type','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

    public function entType() {

        return $this->belongsTo('App\EntType', 'ent_type_id', 'id');
    }

}
