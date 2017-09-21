<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActorCanReadEntType extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'actor_can_read_ent_type';

    public $timestamps = true;

    protected $fillable = [
        'property_need',
        'ent_type_info',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function entType() {

        return $this->belongsTo('App\EntType', 'ent_type_info', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
