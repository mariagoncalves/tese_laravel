<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCanReadResult extends Model
{
    use SoftDeletes;

    protected $table = 'property_can_read_result';

    public $timestamps = true;

    protected $fillable = [
        'reading_property',
        'providing_result',
        'output_type',
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
