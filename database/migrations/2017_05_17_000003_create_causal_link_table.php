<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCausalLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('causal_link', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('causing_t')->unsigned();
            $table->integer('t_state_id')->unsigned();
            $table->integer('caused_t')->unsigned();
            $table->string('min', 45);
            $table->string('max', 45);
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->integer('causing_t')->unsigned();
//            $table->integer('t_state_id')->unsigned();
//            $table->integer('caused_t')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('causal_link');
    }
}