<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessType extends Model
{
    protected $table = 'process_type';

    public $timestamps = true;

    protected $fillable = [
        'state',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function processes() {
        return $this->hasMany('App\Process', 'process_type_id', 'id');
    }

    public function transactionsTypes() {
        return $this->hasMany('App\TransactionType', 'process_type_id', 'id');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'process_type_name', 'process_type_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
}
