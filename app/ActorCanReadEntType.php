<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorCanReadEntType extends Model
{
    protected $table = 'actor_can_read_ent_type';

    public $timestamps = true;

    protected $fillable = [
        'property_need',
        'ent_type_info',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
