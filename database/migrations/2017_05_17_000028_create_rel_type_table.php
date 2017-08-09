<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ent_type1_id')->unsigned();
            $table->integer('ent_type2_id')->unsigned();
            $table->enum('state', ['active', 'inactive']);
            $table->integer('t_state_id')->nullable()->unsigned();
//            $table->timestamp('updated_on');
//            $table->string('name', 128)->nullable();
            $table->integer('transaction_type_id')->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('ent_type1_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
//            $table->foreign('ent_type2_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('rel_type');
    }
}