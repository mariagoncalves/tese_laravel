<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/translations/{lang}/{part}.json', function($lang,$part) {
    return File::get(public_path() . '/app/translations/' . $lang . '/' . $part .'.json');
});
//TIPOS DE PROCESSO
Route::get('/processTypesManage', 'ProcessTypes@index');
Route::get('/proc_types/get_proc/{id?}', 'ProcessTypes@getAll');
Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/Process_Type', 'ProcessTypes@insert');
Route::post('/Process_Type/{id}', 'ProcessTypes@update');
Route::post('/Process_Type_del/{id}', 'ProcessTypes@delete');
//FIM

//INSERIR PROCESSOS
Route::get('/processesManage', 'Processes@index');
Route::get('/procs/get_procs/{id?}','Processes@getAll');
Route::post('/Process', 'Processes@insert');
Route::get('/proc_types/get_procs_types', 'Processes@getAllProcsTypes');
//FIM

Route::get('/transacs_types/get_transacs_types1/{id?}','TransactionTypes@getAll_test');
//TIPOS DE TRANSACÇÕES
Route::get('/transactionTypesManage', 'TransactionTypes@index');
Route::get('/transacs_types/get_transacs_types/{id?}','TransactionTypes@getAll');
Route::post('/Transaction_Type', 'TransactionTypes@insert');
Route::post('/Transaction_Type/{id}', 'TransactionTypes@update');
Route::post('/Transaction_Type_del/{id}', 'TransactionTypes@delete');
Route::get('/exec/get_executers', 'TransactionTypes@getAllExecuters');
//FIM

//INSERIR TRANSACÇÕES
Route::get('/transactionsManage', 'Transactions@index');
Route::get('/transacs/get_transacs/{id?}','Transactions@getAll');
Route::post('/Transaction', 'Transactions@insert');
Route::get('/processes/get_processes', 'Transactions@getAllProcesses');
Route::get('/processes/get_transacs_types', 'Transactions@getAllTransactionsTypes');


//TIPOS DE ENTIDADES
Route::get('/entityTypesManage', 'EntTypes@index');
Route::get('/ents_types/get_ents_types/{id?}','EntTypes@getAll');
Route::post('/Entity_Type', 'EntTypes@insert');
Route::post('/Entity_Type/{id}', 'EntTypes@update');
Route::post('/Entity_Type_del/{id}', 'EntTypes@delete');
Route::get('/ents_types/get_enttypes', 'EntTypes@getAllEntTypes');
Route::get('/ents_types/get_transacs_types', 'EntTypes@getAllTransactionTypes');
Route::get('/ents_types/get_tstates', 'EntTypes@getAllTStates');


//CASUAL LINKS
Route::get('/CausalLinksManage', 'CausalLinksController@index');
Route::get('/causal_links/get_causal_links/{id?}','CausalLinksController@getAll');
Route::post('/Causal_Link', 'CausalLinksController@insert');
Route::post('/Causal_Link/{id}', 'CausalLinksController@update');
Route::post('/Causal_Link_del/{id}', 'CausalLinksController@delete');


//WAITING LINKS
Route::get('/WaitingLinksManage', 'WaitingLinksController@index');
Route::get('/waiting_links/get_waiting_links/{id?}','WaitingLinksController@getAll');
Route::post('/Waiting_Link', 'WaitingLinksController@insert');
Route::post('/Waiting_Link/{id}', 'WaitingLinksController@update');
Route::post('/Waiting_Link_del/{id}', 'WaitingLinksController@delete');


//T STATE
Route::get('/tStatesManage', 'TStatesController@index');
Route::get('/t_states/get_t_state/{id?}', 'TStatesController@getAll');
Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/T_State', 'TStatesController@insert');
Route::post('/T_State/{id}', 'TStatesController@update');
Route::post('/T_State_del/{id}', 'TStatesController@delete');

//Dashboard
Route::get('/dashboardManage', 'DashboardController@index');
Route::get('/dashboard/get_transtypeusercaninit', 'DashboardController@getTransTypeUserCanInit');
Route::get('/dashboard/get_props_form/{id}', 'DashboardController@getProps');
Route::get('/dashboard/get_props_form_child/{id}', 'DashboardController@getPropsfromChild');

Route::get('/dashboard/get_test', 'DashboardController@getAll');

Route::get('/modalTask', function () {
    return view('dashboard/modalTask');
});
Route::get('/modalProcess', function () {
    return view('dashboard/modalProcess');
});
Route::get('/tabTask', function () {
    return view('dashboard/tabTask');
});
Route::get('/tabFormTask', function () {
    return view('dashboard/tabFormTask');
});

Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/Process_Type', 'ProcessTypes@insert');
Route::post('/Process_Type/{id}', 'ProcessTypes@update');
Route::post('/Process_Type_del/{id}', 'ProcessTypes@delete');

//***********************************MARIA****************************//
//Properties Home Page
//Route::get('/propertiesManage', 'PropertiesManagment@index'); //método inválido
/*Route::get('/properties/states', 'PropertiesManagment@getStates');
Route::get('/properties/valueTypes', 'PropertiesManagment@getValueTypes');
Route::get('/properties/fieldTypes', 'PropertiesManagment@getFieldTypes');
Route::get('/properties/units', 'PropertiesManagment@getUnits');*/

//Properties Of Relations
/*Route::get('/propertiesManageRel', 'PropertiesManagment@getAllPropertiesOfRelations');
Route::get('/properties/get_props_rel', 'PropertiesManagment@getAllRel');
Route::post('/PropertyRel', 'PropertiesManagment@insertPropsRel');
Route::post('/PropertyRel/{id?}', 'PropertiesManagment@updatePropsRel');*/


//Route::get('/properties/get_property/{id?}', 'PropertiesManagment@getProperty');

//inserir e update entidades
//Route::post('/PropertyEnt', 'PropertiesManagment@insertPropsEnt');
//Route::post('/PropertyEnt/{id?}', 'PropertiesManagment@updatePropsEnt');

//Route::get('/propertiesManageEnt', 'PropertiesManagment@getAllPropertiesOfEntities');
//Route::get('/properties/get_props_ents', 'PropertiesManagment@getAllEnt');


//Testes
/*Route::get('/properties/getPropsRelation/{id?}', 'PropertiesManagment@getPropsRelations');
Route::post('/updateOrder', 'PropertiesManagment@updateOrderProps');*/

//Route::get('/properties/getPropsEntity/{id?}', 'PropertiesManagment@getPropsEntities');
//Route::post('/updateOrderEnt', 'PropertiesManagment@updateOrderPropsEnt');



// Rotas da gestão de Relações

Route::get('/relationTypesManage/', 'RelationManagement@index');
Route::get('/relTypes/get_relations', 'RelationManagement@getAllRels');
Route::get('/getAllEntities', 'RelationManagement@getEntities');
Route::get('/getAllTransactionTypes', 'RelationManagement@getTransactionTypes');
Route::get('/getAllTransactionStates', 'RelationManagement@getTransactionStates');
Route::post('/Relation', 'RelationManagement@insertRelations');
Route::post('/Relation/{id?}', 'RelationManagement@updateRelationType');
Route::get('/getRelationsTypes/{id?}', 'RelationManagement@getRelations');
Route::post('/Relation_Type_remove/{id}', 'RelationManagement@remove');
Route::get('/modalrelType', function () {
    return view('reltype/modalRelType');
});

//Novas rotas com entidades separadas das relações
//----------------------------------Propriedades da Entidade----------------------------------------------------

Route::get('/propertiesManageEnt', 'PropertiesOfEntitiesController@getAllPropertiesOfEntities');
Route::get('/properties/get_props_ents', 'PropertiesOfEntitiesController@getAllEnt');

Route::post('/PropertyEnt', 'PropertiesOfEntitiesController@insertPropsEnt');
Route::post('/PropertyEnt/{id?}', 'PropertiesOfEntitiesController@updatePropsEnt');
Route::get('/properties/getPropsEntity/{id?}', 'PropertiesOfEntitiesController@getPropsEntities');
Route::post('/updateOrderEnt', 'PropertiesOfEntitiesController@updateOrderPropsEnt');
Route::get('/modalPropsEnt', function () {
    return view('properties/modalPropsEnt');
});

Route::get('/modalDragDropPropsEnt', function () {
    return view('properties/modalDragDropPropsEnt');
});

Route::post('/PropertyOfEntities_remove/{id}', 'PropertiesOfEntitiesController@remove');

Route::get('/modalConfirm', function () {
    return view('properties/modalConfirm');
});

//----------------------------------Propriedades da Relação----------------------------------------------------

Route::get('/propertiesManageRel', 'PropertiesOfRelationsController@getAllPropertiesOfRelations');
Route::get('/properties/get_props_rel', 'PropertiesOfRelationsController@getAllRel');
Route::post('/PropertyRel', 'PropertiesOfRelationsController@insertPropsRel');
Route::post('/PropertyRel/{id?}', 'PropertiesOfRelationsController@updatePropsRel');
Route::get('/properties/getPropsRelation/{id?}', 'PropertiesOfRelationsController@getPropsRelations');
Route::post('/updateOrder', 'PropertiesManagment@updateOrderProps');

Route::get('/modalPropsRel', function () {
    return view('properties/modalPropsRel');
});

//--------------------------Métodos comuns as entidades e as relações---------------------------

Route::get('/properties/states', 'PropertiesController@getStates');
Route::get('/properties/valueTypes', 'PropertiesController@getValueTypes');
Route::get('/properties/fieldTypes', 'PropertiesController@getFieldTypes');
Route::get('/properties/units', 'PropertiesController@getUnits');
Route::get('/properties/get_property/{id?}', 'PropertiesController@getProperty');

//----------------------------------Pesquisa Dinâmica----------------------------------------------------

Route::get('/dynamicSearch', 'DynamicSearchController@index');
Route::get('/dynamicSearch/entities', 'DynamicSearchController@getEntities');
Route::get('/dynamicSearch/entity/{id?}', 'DynamicSearchController@getEntitiesData');
Route::get('/dynamicSearch/entityDetails/{id?}', 'DynamicSearchController@getEntitiesDetails');
Route::get('/dynamicSearch/getOperators', 'DynamicSearchController@getOperators');
Route::get('/dynamicSearch/getEnumValues/{id?}', 'DynamicSearchController@getEnumValues');
Route::get('/dynamicSearch/getEntityInstances/{entityId?}/{propId?}', 'DynamicSearchController@getEntityInstances');
Route::get('/dynamicSearch/getEntRefs/{id?}', 'DynamicSearchController@getEntRefs');
Route::get('/dynamicSearch/getPropsOfEnts/{id?}', 'DynamicSearchController@getPropsOfEnts');
Route::get('/dynamicSearch/getRelsWithEnt/{id?}', 'DynamicSearchController@getRelsWithEnt');
Route::get('/dynamicSearch/getEntsRelated/{idRelType?}/{idEntType}', 'DynamicSearchController@getEntsRelated');
Route::get('/dynamicSearch/getPropsEntRelated/{id?}', 'DynamicSearchController@getPropsEntRelated');


Route::get('/dynamicSearch/pesquisa/{id?}', 'DynamicSearchController@pesquisa');











//******************************************Duarte***********************************************//
//Users
Route::get('/usersManage', 'UsersController@index');
Route::get('/get_users', 'UsersController@getAll');
Route::get('/get_users/{id?}', 'UsersController@getAll');
Route::post('/users', 'UsersController@insert');
Route::post('/users/{id?}', 'UsersController@update');
Route::post('/users/remove/{id?}', 'UsersController@remove');
Route::get('/users/get_langs', 'UsersController@getLangs');
Route::get('/users/get_entities', 'UsersController@getEntities');

Route::get('/users/get_roles', 'UsersController@getRoles');
Route::get('/users/get_selroles/{id}', 'UsersController@getSelRoles');
Route::post('/users/update_roles/{id}', 'UsersController@updateRoles');
Route::get('/users/view_roles', 'UsersController@viewRoles');
Route::post('/remove_user_role/', 'UsersController@removeRole');

//Languages
Route::get('/languagesManage', 'LanguageController@index');
Route::get('/get_languages', 'LanguageController@getAll');
Route::get('/get_languages/{id?}', 'LanguageController@getAll');
Route::post('/languages', 'LanguageController@insert');
Route::post('/languages/{id?}', 'LanguageController@update');
Route::post('/languages/remove/{id?}', 'LanguageController@remove');

//Actors
Route::get('/actorsManage', 'ActorController@index');
Route::get('/get_actors', 'ActorController@getAll');
Route::get('/get_actors/{id?}', 'ActorController@getAll');
Route::post('/actors', 'ActorController@insert');
Route::post('/actors/{id?}', 'ActorController@update');
Route::post('/actors/remove/{id?}', 'ActorController@remove');

Route::get('/actors/get_roles', 'ActorController@getRoles');
Route::get('/actors/get_selroles/{id}', 'ActorController@getSelRoles');
Route::post('/actors/update_roles/{id}', 'ActorController@updateRoles');
Route::get('/actors/view_roles', 'ActorController@viewRoles');
Route::post('/remove_actor_role/', 'ActorController@removeRole');

//Roles
Route::get('/rolesManage', 'RoleController@index');
Route::get('/get_roles', 'RoleController@getAll');
Route::get('/get_roles/{id?}', 'RoleController@getAll');
Route::post('/roles', 'RoleController@insert');
Route::post('/roles/{id?}', 'RoleController@update');
Route::post('/roles/remove/{id?}', 'RoleController@remove');

Route::get('/roles/get_actors', 'RoleController@getActors');
Route::get('/roles/get_selactors/{id}', 'RoleController@getSelActors');
Route::post('/roles/update_actors/{id}', 'RoleController@updateActors');
Route::get('/roles/view_actors', 'RoleController@viewActors');
Route::post('/remove_actor_role/', 'RoleController@removeActors');

Route::get('/roles/get_users', 'RoleController@getUsers');
Route::get('/roles/get_selusers/{id}', 'RoleController@getSelUsers');
Route::post('/roles/update_users/{id}', 'RoleController@updateUsers');
Route::get('/roles/view_users', 'RoleController@viewUsers');
Route::post('/remove_user_role/', 'RoleController@removeUsers');


//*********************************************Guilherme*************************************************//
//Prop_unit_type
Route::get('/propUnitTypeManage/', 'PropUnitTypes@index');
Route::get('/prop_unit_types/get_unit', 'PropUnitTypes@getAll');
Route::get('/prop_unit_types/get_unit/{id?}', 'PropUnitTypes@getAll');

Route::post('/Prop_Unit_Type', 'PropUnitTypes@insert');
Route::post('/Prop_Unit_Type/{id?}', 'PropUnitTypes@update');


//Prop_allowed_value
Route::get('/propAllowedValueManage/', 'PropAllowedValueController@index');
Route::get('/prop_allowed_value/get_unit', 'PropAllowedValueController@getAll');
Route::get('/prop_allowed_value/get_unit/{id?}', 'PropAllowedValueController@getAll');
Route::get('/prop_allowed_value/get_properties', 'PropAllowedValueController@getProp');

Route::post('/Prop_Allowed_Value', 'PropAllowedValueController@insert');
Route::post('/Prop_Allowed_Value/{id?}', 'PropAllowedValueController@update');