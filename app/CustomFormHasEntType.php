<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomFormHasEntType extends Model
{
    use SoftDeletes;

    protected $table = 'custom_form_has_ent_type';

    public $timestamps = true;

    protected $fillable = [
        'ent_type_id',
        'custom_form_id',
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
