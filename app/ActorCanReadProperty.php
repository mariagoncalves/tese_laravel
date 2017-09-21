<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActorCanReadProperty extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'actor_can_read_property';

    public $timestamps = true;

    protected $fillable = [
        'property_need',
        'property_info',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function property() {
        return $this->belongsTo('App\Property', 'property_info', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
