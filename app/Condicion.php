<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condicion extends Model
{
     use SoftDeletes;

    protected $table = 'condicion';

    public $timestamps = true;

    protected $fillable = [
        'query_id',
        'operator_id',
		'property_id',
		'value_id',
		'value',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function operator() {

        return $this->belongsTo('App\Operator');
    }

    public function query() {

        return $this->belongsTo('App\Query');
    }

    public function property() {

        return $this->belongsTo('App\Property');
    }

    public function value() {

        return $this->belongsTo('App\Value');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
