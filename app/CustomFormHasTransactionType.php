<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomFormHasTransactionType extends Model
{
    use SoftDeletes;

    protected $table = 'custom_form_has_transaction_type';

    public $timestamps = true;

    protected $fillable = [
    	'custom_form_id',
        'transaction_type_id',
        'field_order',
        'mandatory_form',
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
