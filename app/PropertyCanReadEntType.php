<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCanReadEntType extends Model
{
    use SoftDeletes;

    protected $table = 'property_can_read_ent_type';

    public $timestamps = true;

    protected $fillable = [
        'reading_property',
        'providing_ent_type',
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
