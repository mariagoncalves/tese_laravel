<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rel_type_id')->unsigned();
            //falta relação?
            $table->integer('entity1_id')->unsigned();
            $table->integer('entity2_id')->unsigned();
            $table->integer('transaction_state_id')->unsigned();
//            $table->string('relation_name', 255)->nullable();
            $table->enum('state', ['active', 'inactive']);
//            $table->timestamp('updated_on');
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('rel_type_id')->references('id')->on('rel_type')->onDelete('no action')->onUpdate('no action');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('relation');
    }
}