<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCanReadProperty extends Model
{
    use SoftDeletes;

    protected $table = 'property_can_read_property';

    public $timestamps = true;

    protected $fillable = [
        'reading_property',
        'providing_property',
        'output_type',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function property() {
        return $this->belongsTo('App\Property', 'providing_property', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
