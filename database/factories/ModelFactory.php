<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Language::class, function (Faker\Generator $faker, $attributes) {
	$name = ''; $slug = ''; $updated_by = NULL; $deleted_by = NULL;

	if (isset($attributes['updated_by']) && $attributes['updated_by'] != "") {
		$updated_by = $attributes['updated_by'];
	}

	if (isset($attributes['deleted_by']) && $attributes['deleted_by'] != "") {
		$updated_by = $attributes['deleted_by'];
	}

	if (isset($attributes['name']) && $attributes['name'] != "") {
		$name = $attributes['name'];
	}

	if (isset($attributes['slug']) && $attributes['slug'] != "") {
		$slug = $attributes['slug'];
	}

    return [
        'name' 		 => $name,
        'slug' 		 => $slug,
        'state' 	 => 'active',
        'updated_by' => $updated_by,
        'deleted_by' => $deleted_by,
    ];
});


$factory->define(App\Users::class, function (Faker\Generator $faker) {
    return [
        'name' 		  => $faker->name,
        'email' 	  => $faker->unique()->safeEmail,
        'password'    => bcrypt('123456789'),
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'user_name'	  => $faker->firstName,
        'user_type'   => 'internal',
        'entity_id'   => NULL
    ];
});

$factory->define(App\PropUnitType::class, function (Faker\Generator $faker) {
    return [
        'state'   	 => 'active',
        'updated_by' => App\Users::all()->random()->id,
        'deleted_by' => NULL,
    ];
});


$factory->define(App\PropUnitTypeName::class, function (Faker\Generator $faker) {
    return [
        'prop_unit_type_id' => App\PropUnitType::all()->random()->id,
        'language_id'		=> App\Language::where('slug', 'pt')->first()->id,
        'name'				=> $faker->name,
        'updated_by' 		=> App\Users::all()->random()->id,
        'deleted_by' 		=> NULL,
    ];
});

$factory->define(App\ProcessType::class, function (Faker\Generator $faker) {
    return [
        'state'   	 => 'active',
        'updated_by' => App\Users::all()->random()->id,
        'deleted_by' => NULL,
    ];
});

$factory->define(App\ProcessTypeName::class, function (Faker\Generator $faker) {
    return [
        'process_type_id' => App\ProcessType::all()->random()->id,
        'language_id'	  => App\Language::where('slug', 'pt')->first()->id,
        'name'			  => $faker->name,
        'updated_by' 	  => App\Users::all()->random()->id,
        'deleted_by' 	  => NULL,
    ];
});

$factory->define(App\CustomForm::class, function (Faker\Generator $faker) {
    return [
        'state'   	 => 'active',
        'updated_by' => App\Users::all()->random()->id,
        'deleted_by' => NULL,
    ];
});

$factory->define(App\CustomFormName::class, function (Faker\Generator $faker) {
    return [
        'custom_form_id' => App\CustomForm::all()->random()->id,
        'language_id'	 => App\Language::where('slug', 'pt')->first()->id,
        'name'			 => "Formulario ".$faker->company,
        'updated_by' 	 => App\Users::all()->random()->id,
        'deleted_by' 	 => NULL,
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'updated_by' => App\Users::all()->random()->id,
        'deleted_by' => NULL,
    ];
});

$factory->define(App\RoleName::class, function (Faker\Generator $faker) {
    return [
        'role_id'	  => App\Role::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => $faker->jobTitle,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});


$factory->define(App\Actor::class, function (Faker\Generator $faker) {
    return [
        'updated_by' => App\Users::all()->random()->id,
        'deleted_by' => NULL,
    ];
});

$factory->define(App\ActorName::class, function (Faker\Generator $faker) {
    return [
        'actor_id'	  => App\Actor::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => "Decisor ".$faker->name,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\RoleHasActor::class, function (Faker\Generator $faker) {
    return [
        'role_id'	  => App\Role::all()->random()->id,
        'actor_id'    => App\Actor::all()->random()->id,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\RoleHasUser::class, function (Faker\Generator $faker) {
    return [
        'role_id'	  => App\Role::all()->random()->id,
        'user_id'     => App\Users::all()->random()->id,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\Process::class, function (Faker\Generator $faker) {
    return [
    	'process_type_id' => App\ProcessType::all()->random()->id,
        'updated_by'      => App\Users::all()->random()->id,
        'deleted_by'      => NULL,
    ];
});

$factory->define(App\ProcessName::class, function (Faker\Generator $faker) {
    return [
        'process_id'  => App\Process::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => "Gestão nº".$faker->randomDigit,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\TState::class, function (Faker\Generator $faker) {
    return [
        'updated_by'      => App\Users::all()->random()->id,
        'deleted_by'      => NULL,
    ];
});

$factory->define(App\TStateName::class, function (Faker\Generator $faker) {
    return [
        't_state_id'  => App\TState::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => $faker->name,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\TransactionType::class, function (Faker\Generator $faker, $attributes) {
	$user = App\Users::all()->random()->id;

	if (isset($attributes['executer']) && $attributes['executer'] != "") {
		$user = $attributes['executer'];
	}

	if (isset($attributes['updated_by']) && $attributes['updated_by'] != "") {
		$user = $attributes['updated_by'];
	}

    return [
        'state'  		  => 'active',
        'process_type_id' => App\ProcessType::all()->random()->id,
        'executer'		  => $user,
        'updated_by'      => $user,
        'deleted_by'      => NULL,
    ];
});

$factory->define(App\TransactionTypeName::class, function (Faker\Generator $faker) {
    return [
        'transaction_type_id'  => App\TransactionType::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        't_name'	  => $faker->name,
        'rt_name'	  => $faker->name,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\EntType::class, function (Faker\Generator $faker) {
    return [
    	'state' 			  => 'active',
		'has_child' 		  => '0',
		'has_par' 			  => '0',
		'transaction_type_id' => App\TransactionType::all()->random()->id,
		'par_ent_type_id' 	  => NULL,
		'par_prop_type_val'   => NULL,
		't_state_id' 		  => App\TState::all()->random()->id,
        'updated_by'          => App\Users::all()->random()->id,
        'deleted_by'          => NULL,
    ];
});

$factory->define(App\EntTypeName::class, function (Faker\Generator $faker) {
    return [
        'ent_type_id' => App\EntType::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => $faker->jobTitle,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\Entity::class, function (Faker\Generator $faker) {
    return [
    	'ent_type_id' => App\EntType::all()->random()->id,
		'state' 	  => 'active',
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\EntityName::class, function (Faker\Generator $faker) {
    return [
        'entity_id'   => App\Entity::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => $faker->jobTitle,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\RelType::class, function (Faker\Generator $faker, $attributes) {
	$ent_type1_id = App\EntType::all()->random()->id;
	$ent_type2_id = App\EntType::where('id', '!=', $ent_type1_id)->get()->random()->id;

	if (isset($attributes['ent_type1_id']) && $attributes['ent_type1_id'] != "") {
		$ent_type1_id = $attributes['ent_type1_id'];
	}

	if (isset($attributes['ent_type2_id']) && $attributes['ent_type2_id'] != "") {
		$ent_type2_id = $attributes['ent_type2_id'];
	}

    return [
		'ent_type1_id' 		  => $ent_type1_id,
		'ent_type2_id' 		  => $ent_type2_id,
		't_state_id' 		  => App\TState::all()->random()->id,
		'state' 			  => 'active',
		'transaction_type_id' => App\TransactionType::all()->random()->id,
        'updated_by'  		  => App\Users::all()->random()->id,
        'deleted_by'  		  => NULL,
    ];
});

$factory->define(App\RelTypeName::class, function (Faker\Generator $faker) {
    return [
        'rel_type_id' => App\RelType::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => "Relação nº".$faker->randomDigit,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
    	'transaction_type_id' => App\TransactionType::all()->random()->id,
		'state' 	          => 'active',
		'process_id'          => App\Process::all()->random()->id,
        'updated_by'          => App\Users::all()->random()->id,
        'deleted_by'          => NULL,
    ];
});

$factory->define(App\TransactionState::class, function (Faker\Generator $faker) {
    return [
    	'transaction_id' => App\Transaction::all()->random()->id,
		't_state_id' 	 => App\TState::all()->random()->id,
        'updated_by'     => App\Users::all()->random()->id,
        'deleted_by'     => NULL,
    ];
});

$factory->define(App\TransactionAck::class, function (Faker\Generator $faker) {
    return [
		'user_id'              	=> App\Users::all()->random()->id,
		'viewed_on'				=> date("Y-m-d H:i:s"),
		'transaction_state_id'  => App\TransactionState::all()->random()->id,
        'updated_by'            => App\Users::all()->random()->id,
        'deleted_by'            => NULL,
    ];
});

$factory->define(App\ActorIniciatesT::class, function (Faker\Generator $faker) {
    return [
		'transaction_type_id'	=> App\TransactionType::all()->random()->id,
		'actor_id'  			=> App\Actor::all()->random()->id,
        'updated_by'            => App\Users::all()->random()->id,
        'deleted_by'            => NULL,
    ];
});

$factory->define(App\Property::class, function (Faker\Generator $faker) {
	$rand = rand(1, 100); $ent = NULL; $rel = NULL;

	if ($rand > 50) {
		$ent = App\EntType::all()->random()->id;
	} else {
		$rel = App\RelType::all()->random()->id;
	}

	$valuesType = ['text', 'bool', 'int', 'ent_ref', 'double', 'enum'];
	$fieldType  = ['text', 'textbox', 'radio', 'checkbox', 'selectbox'];
	$state      = ['active', 'inactive'];


    return [
		'ent_type_id'	   => $ent, 
		'rel_type_id'	   => $rel,
		'value_type'	   => $valuesType[rand(0, 5)],
		'form_field_type'  => $fieldType[rand(0, 4)],
		'unit_type_id' 	   => ((rand(1, 100) > 50) ? App\PropUnitType::all()->random()->id : NULL),
		'form_field_order' => rand(1, 100),
		'mandatory'		   => rand(0, 1),
		'state'			   => $state[rand(0, 1)],
		'fk_ent_type_id'   => NULL,
		'form_field_size'  => rand(1, 500),
        'updated_by'       => App\Users::all()->random()->id,
        'deleted_by'       => NULL,
    ];
});


$factory->define(App\PropertyName::class, function (Faker\Generator $faker) {
    return [
        'property_id' => App\Property::all()->random()->id,
        'language_id' => App\Language::where('slug', 'pt')->first()->id,
        'name'		  => $faker->name,
        'form_field_name' => $faker->name,
        'updated_by'  => App\Users::all()->random()->id,
        'deleted_by'  => NULL,
    ];
});
