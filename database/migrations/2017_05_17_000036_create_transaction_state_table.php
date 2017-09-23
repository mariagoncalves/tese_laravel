<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_state', function (Blueprint $table) {
            $table->increments('id');
//            $table->timestamp('updated_on');
            $table->integer('transaction_id')->unsigned();
            $table->integer('t_state_id')->unsigned();
            $table->integer('d_init_state_id')->nullable()->unsigned();
            $table->integer('d_exec_state_id')->nullable()->unsigned();
            //ligação?
//            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('transaction_id')->references('id')->on('transaction')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('transaction_state');
    }
}