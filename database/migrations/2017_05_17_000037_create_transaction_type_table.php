<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_type', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name', 45);
            $table->enum('state', ['active', 'inactive']);
//            $table->timestamp('updated_on');
            $table->integer('process_type_id')->unsigned();
			$table->boolean('init_proc');
//            $table->string('result_type', 500);
            $table->integer('executer')->unsigned();
            $table->boolean('auto_activate');
            $table->string('freq_activate', 45)->nullable();
            $table->time('when_activate')->nullable();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('process_type_id')->references('id')->on('process_type')->onDelete('no action')->onUpdate('no action');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('transaction_type');
    }
}