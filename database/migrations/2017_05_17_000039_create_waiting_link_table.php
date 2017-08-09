<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitingLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_link', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('waited_t')->unsigned();
            $table->integer('waited_fact')->unsigned();
            $table->integer('waiting_fact')->unsigned();
            $table->integer('waiting_transaction')->unsigned();
            $table->integer('min');
            $table->integer('max');
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('waited_t')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
//            $table->foreign('waited_fact')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
//            $table->foreign('waiting_fact')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
//            $table->foreign('waiting_transaction')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('waiting_link');
    }
}