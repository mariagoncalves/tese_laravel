<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CausalLink extends Model
{
    use SoftDeletes;

    protected $table = 'causal_link';

    public $timestamps = true;

    protected $fillable = [
        'causing_t',
        't_state_id',
        'caused_t',
        'min',
        'max',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function causingTransaction() {
        return $this->belongsTo('App\TransactionType', 'causing_t', 'id');
    }

    public function causedTransaction() {
        return $this->belongsTo('App\TransactionType', 'caused_t', 'id');
    }

    public function tState() {
        return $this->belongsTo('App\TState', 't_state_id', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
