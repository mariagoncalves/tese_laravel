<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use SoftDeletes;

    protected $table = 'operator';

    public $timestamps = true;

    protected $fillable = [
        'operator_type',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function condicions() {

        return $this->hasMany('App\Condicion', 'operator_id', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
