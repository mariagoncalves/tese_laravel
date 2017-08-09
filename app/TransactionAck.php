<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionAck extends Model
{
    protected $table = 'transaction_ack';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'viewed_on',
        'transaction_state_id',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function transactionState() {
        return $this->belongsTo('App\TransactionState', 'transaction_state_id', 'id');
    }

    public function agent() {
        return $this->belongsTo('App\Agent', 'agent_id', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

}
