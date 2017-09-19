<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorCanReadPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_can_read_property', function (Blueprint $table) {
            $table->integer('property_need')->unsigned();
            $table->integer('property_info')->unsigned();
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
        Schema::table('actor_can_read_property');
    }
}