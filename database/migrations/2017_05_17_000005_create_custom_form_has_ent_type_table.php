<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFormHasEntTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_form_has_ent_type', function (Blueprint $table) {
            $table->integer('ent_type_id')->unsigned();
            $table->integer('custom_form_id')->unsigned();
            $table->integer('field_order')->nullable();
            $table->integer('mandatory_form');
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->integer('property_id')->unsigned();
//            $table->integer('custom_form_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('custom_form_has_ent_type');
    }
}