<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyCanReadEntTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_can_read_ent_type', function (Blueprint $table) {
            $table->integer('reading_property')->unsigned();
            $table->integer('providing_ent_type')->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('property_need')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            // $table->foreign('property_info')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_can_read_property');
    }
}