<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ent_type', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name', 128);
            $table->enum('state', ['active','inactive']);
            $table->boolean('has_child');
            $table->boolean('has_par');
//            $table->timestamp('updated_on');
            $table->integer('transaction_type_id')->unsigned();
            $table->integer('par_ent_type_id')->nullable()->unsigned();
            $table->integer('par_prop_type_val')->nullable()->unsigned();
            $table->integer('t_state_id')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

//            $table->integer('ent_type_id')->unsigned();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('ent_type');
    }
}