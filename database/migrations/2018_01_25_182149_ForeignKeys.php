<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Updated by e Deleted by

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('language')->onDelete('no action')->onUpdate('no action');
            $table->foreign('entity_id')->references('id')->on('entity')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('actor', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('actor_iniciates_t', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('causal_link', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('custom_form', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('custom_form_has_transaction_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('ent_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('entity', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('process', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('process_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('prop_allowed_value', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('prop_unit_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('property', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('rel_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('relation', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('role', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('role_has_actor', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('role_has_user', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('t_state', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction_ack', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction_state', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('value', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('waiting_link', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('language', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('actor_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('custom_form_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('ent_type_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('entity_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('process_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('process_type_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('prop_allowed_value_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('prop_unit_type_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('property_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('rel_type_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('relation_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('role_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('t_state_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction_type_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('value_name', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_property', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_ent_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('operator', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('query', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('condicion', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_result', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_rel_type', function(Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });


//        Schema::table('agent', function (Blueprint $table) {
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
//        });

        Schema::table('actor_iniciates_t', function(Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('actor_id')->references('id')->on('actor')->onDelete('no action')->onUpdate('no action');
            $table->primary(array('transaction_type_id', 'actor_id'));
        });
//
//
        Schema::table('causal_link', function(Blueprint $table) {
            $table->foreign('causing_t')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('t_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
            $table->foreign('caused_t')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
        });
//
//
        Schema::table('custom_form_has_transaction_type', function(Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('custom_form_id')->references('id')->on('custom_form')->onDelete('no action')->onUpdate('no action');
            //$table->primary(array('transaction_type_id', 'custom_form_id'));
        });
//
        Schema::table('ent_type', function(Blueprint $table) {
        $table->foreign('par_ent_type_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
        $table->foreign('par_prop_type_val')->references('id')->on('prop_allowed_value')->onDelete('no action')->onUpdate('no action');
        });
//
//

//
        Schema::table('entity', function(Blueprint $table) {
            $table->foreign('ent_type_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
			$table->foreign('transaction_state_id')->references('id')->on('transaction_state')->onDelete('no action')->onUpdate('no action');
        });

//
        Schema::table('prop_allowed_value', function(Blueprint $table) {

            $table->foreign('property_id')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('rel_type', function(Blueprint $table) {

            $table->foreign('ent_type1_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('ent_type2_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('t_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('relation', function(Blueprint $table) {
            $table->foreign('rel_type_id')->references('id')->on('rel_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('entity1_id')->references('id')->on('entity')->onDelete('no action')->onUpdate('no action');
            $table->foreign('entity2_id')->references('id')->on('entity')->onDelete('no action')->onUpdate('no action');
            $table->foreign('transaction_state_id')->references('id')->on('transaction_state')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('rel_type', function(Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('role_has_actor', function(Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('role')->onDelete('no action')->onUpdate('no action');
            $table->foreign('actor_id')->references('id')->on('actor')->onDelete('no action')->onUpdate('no action');
            $table->primary(array('role_id', 'actor_id'));
        });
//
        Schema::table('role_has_user', function(Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('role')->onDelete('no action')->onUpdate('no action');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->primary(array('role_id', 'user_id'));
        });
//
        Schema::table('transaction', function(Blueprint $table) {
            $table->foreign('process_id')->references('id')->on('process')->onDelete('no action')->onUpdate('no action');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('transaction_ack', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('transaction_state_id')->references('id')->on('transaction_state')->onDelete('no action')->onUpdate('no action');

        });
//
        Schema::table('transaction_state', function(Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transaction')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('transaction_type', function(Blueprint $table) {
            $table->foreign('process_type_id')->references('id')->on('process_type')->onDelete('no action')->onUpdate('no action');

        });
//
        Schema::table('value', function(Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
        });
//
        Schema::table('waiting_link', function(Blueprint $table) {
            $table->foreign('waited_t')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('waited_fact')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
            $table->foreign('waiting_fact')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
            $table->foreign('waiting_transaction')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
        });
//


//
        Schema::table('transaction_type', function (Blueprint $table) {
            $table->foreign('executer')->references('id')->on('actor')->onDelete('no action')->onUpdate('no action');
        });
//
//        Schema::table('transaction_state', function (Blueprint $table) {
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
//        });

        Schema::table('property', function (Blueprint $table) {
            $table->foreign('ent_type_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('value', function (Blueprint $table) {
            $table->foreign('entity_id')->references('id')->on('entity')->onDelete('no action')->onUpdate('no action');
//            $table->foreign('entity1_id')->references('id')->on('entity')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('process', function (Blueprint $table) {
            $table->foreign('process_type_id')->references('id')->on('process_type')->onDelete('no action')->onUpdate('no action');
        });
//        Schema::table('property', function (Blueprint $table) {
//
//        });
        Schema::table('property', function (Blueprint $table) {
            $table->foreign('unit_type_id')->references('id')->on('prop_unit_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('rel_type_id')->references('id')->on('rel_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('fk_ent_type_id')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
			$table->foreign('fk_property_id')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('value', function (Blueprint $table) {
            $table->foreign('relation_id')->references('id')->on('relation')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('transaction_state', function (Blueprint $table) {
            $table->foreign('t_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
            $table->foreign('d_init_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
            $table->foreign('d_exec_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('ent_type', function (Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('no action')->onUpdate('no action');
            $table->foreign('t_state_id')->references('id')->on('t_state')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_property', function (Blueprint $table) {
            $table->foreign('reading_property')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            $table->foreign('providing_property')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
        });
		
		Schema::table('property_can_read_ent_type', function (Blueprint $table) {
            $table->foreign('reading_property')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            $table->foreign('providing_ent_type')->references('id')->on('ent_type')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('condicion', function (Blueprint $table) {
            $table->foreign('query_id')->references('id')->on('query')->onDelete('no action')->onUpdate('no action');
            $table->foreign('operator_id')->references('id')->on('operator')->onDelete('no action')->onUpdate('no action');
            $table->foreign('property_id')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            $table->foreign('value_id')->references('id')->on('value')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('property_can_read_rel_type', function (Blueprint $table) {
            $table->foreign('reading_property')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            $table->foreign('providing_rel_type')->references('id')->on('rel_type')->onDelete('no action')->onUpdate('no action');
        });
        Schema::table('property_can_read_result', function(Blueprint $table) {
            $table->foreign('reading_property')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            $table->foreign('providing_result')->references('id')->on('query')->onDelete('no action')->onUpdate('no action');
        });

    }

    public function down()
    {

//        Schema::table('agent', function (Blueprint $table) {
//            $table->dropForeign(['user_id']);
//        });

        Schema::table('waiting_link', function (Blueprint $table) {
            $table->dropForeign(['waited_t']);
            $table->dropForeign(['waited_fact']);
            $table->dropForeign(['waiting_fact']);
            $table->dropForeign(['waiting_transaction']);
        });
        Schema::table('value', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });
        Schema::table('transaction_type', function (Blueprint $table) {
            $table->dropForeign(['process_type_id']);
        });

        Schema::table('ent_type', function (Blueprint $table) {
            $table->dropForeign(['transaction_type_id']);
            $table->dropForeign(['transaction_type_id']);
            $table->dropForeign(['transaction_type_id']);
        });
        Schema::table('transaction_state', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });
        Schema::table('transaction_ack', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['transaction_state_id']);
        });
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropForeign(['process_id']);
        });
        Schema::table('transaction_state', function (Blueprint $table) {
            $table->dropForeign(['t_state_id']);
            $table->dropForeign(['d_init_state_id']);
            $table->dropForeign(['d_exec_state_id']);
        });
        Schema::table('role_has_user', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('role_has_actor', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['actor_id']);
        });
        Schema::table('relation', function (Blueprint $table) {
            $table->dropForeign(['rel_type_id']);
        });

        Schema::table('value', function (Blueprint $table) {
            $table->dropForeign(['relation_id']);
        });
        Schema::table('rel_type', function (Blueprint $table) {
            $table->dropForeign(['ent_type1_id']);
            $table->dropForeign(['ent_type2_id']);
        });

        Schema::table('property', function (Blueprint $table) {
            $table->dropForeign(['rel_type_id']);
        });
        Schema::table('property', function (Blueprint $table) {
            $table->dropForeign(['unit_type_id']);
        });
		Schema::table('property', function (Blueprint $table) {
            $table->dropForeign(['fk_property_id']);
        });
        Schema::table('prop_allowed_value', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });
        Schema::table('process', function (Blueprint $table) {
            $table->dropForeign(['process_type_id']);
        });

        Schema::table('entity', function (Blueprint $table) {
            $table->dropForeign(['ent_type_id']);
			$table->dropForeign(['transaction_state_id']);
        });

        Schema::table('value', function (Blueprint $table) {
            $table->dropForeign(['entity_id']);
//            $table->dropForeign(['entity1_id']);
        });

        Schema::table('ent_type', function (Blueprint $table) {
            $table->dropForeign(['par_ent_type_id']);
			$table->dropForeign(['par_prop_type_val']);
        });

        Schema::table('property', function (Blueprint $table) {
            $table->dropForeign(['ent_type_id']);
        });

//        Schema::table('transaction_state', function (Blueprint $table) {
//            $table->dropForeign(['user_id']);
//        });

        Schema::table('transaction_type', function (Blueprint $table) {
            $table->dropForeign(['executer']);
        });

        Schema::table('actor_iniciates_t', function (Blueprint $table) {
            $table->dropForeign(['transaction_type_id']);
            $table->dropForeign(['actor_id']);
        });

        Schema::table('causal_link', function (Blueprint $table) {
            $table->dropForeign(['causing_t']);
            $table->dropForeign(['t_state_id']);
            $table->dropForeign(['caused_t']);
        });
        Schema::table('custom_form_has_transaction_type', function (Blueprint $table) {
            $table->dropForeign(['transaction_type_id']);
            $table->dropForeign(['custom_form_id']);
        });

        Schema::table('property_can_read_result', function (Blueprint $table) {
            $table->dropForeign(['reading_property']);
            $table->dropForeign(['providing_result']);
        });

        Schema::table('property_can_read_ent_type', function (Blueprint $table) {
            $table->dropForeign(['reading_property']);
            $table->dropForeign(['providing_ent_type']);
        });
         Schema::table('property_can_read_rel_type', function (Blueprint $table) {
            $table->dropForeign(['reading_property']);
            $table->dropForeign(['providing_rel_type']);
        });
         Schema::table('condicion', function (Blueprint $table) {
            $table->dropForeign('query_id');
            $table->dropForeign('operator_id');
            $table->dropForeign('property_id');
            $table->dropForeign('value_id');
        });

        // Updated by e Deleted by

        Schema::table('actor', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('actor_iniciates_t', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('causal_link', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('custom_form', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('ent_type', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });

        Schema::table('entity', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('process', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('process_type', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('prop_allowed_value', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('prop_unit_type', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('rel_type', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('relation', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('role', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('role_has_actor', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('role_has_user', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('t_state', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('transaction', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('transaction_ack', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('transaction_state', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('transaction_type', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('value', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('waiting_link', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('language', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('actor_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('custom_form_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('ent_type_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('entity_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('process_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('process_type_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('prop_allowed_value_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('prop_unit_type_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('rel_type_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('relation_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('role_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('t_state_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('transaction_type_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('value_name', function(Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property_can_read_property', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property_can_read_rel_type', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('custom_form_has_transaction_type', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property_can_read_result', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('property_can_read_ent_type', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('operator', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('query', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });
        Schema::table('condicion', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });

    }

}
