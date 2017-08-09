@extends('layouts.default')
@section('content')
    <div ng-controller="entityTypesController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        {{--
        <div ng-controller="entityTypesController as mc">
        <table class="table" st-pipe="mc.callServer" st-table="mc.displayed">
            <thead>
            <tr>
                <th st-sort="id">ID</th>
                <th st-sort="language[0].pivot.name">Name</th>
                <th st-sort="transactions_type.language[0].pivot.t_name">Transaction Type</th>
                <th st-sort="ent_type.language[0].pivot.name">Entity Type</th>
                <th st-sort="t_states.language[0].pivot.name">Transaction State</th>
                <th st-sort="state">State</th>
                <th st-sort="created_at">Created_at</th>
                <th st-sort="language[0].pivot.updated_at">Updated_at</th>
                <th st-sort="deleted_at">Deleted_at</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Adicionar Novo Tipo de Transacção</button></th>

            </tr>
            <tr>
                <th><input st-search="id"/></th>
                <th><input st-search="language[0].pivot.name"/></th>
                <th><input st-search="transactions_type.language[0].pivot.t_name"/></th>
                <th><input st-search="ent_type.language[0].pivot.name"/></th>
                <th><input st-search="t_states.language[0].pivot.name"/></th>
                <th><input st-search="state"/></th>
                <th><input st-search="created_at"/></th>
                <th><input st-search="language[0].pivot.updated_at"/></th>
                <th><input st-search="deleted_at"/></th>
            </tr>
            </thead>
            <tbody ng-show="!mc.isLoading">
            <tr ng-repeat="row in mc.displayed">
                <td>[[ row.id ]]</td>
                <td>[[ row.language[0].pivot.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ row.transactions_type.language[0].pivot.t_name ]]</td>
                <td>[[ row.ent_type.language[0].pivot.name ]]</td>
                <td>[[ row.t_states.language[0].pivot.name ]]</td>
                <td>[[ row.state ]]</td>
                <td>[[ row.created_at ]]</td>
                <td>[[ row.language[0].pivot.updated_at ]]</td>
                <td>[[ row.deleted_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', row.id)">Editar</button>
                    <button class="btn btn-danger btn-xs btn-delete">Histórico</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(row.id)">Apagar</button>
                </td>
            </tr>
            </tbody>
            <tbody ng-show="mc.isLoading">
            <tr>
                <td colspan="7" class="text-center">Loading ... </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td class="text-center" st-pagination="" st-items-by-page="2" colspan="7">
                </td>
            </tr>
            </tfoot>
        </table>--}}

        <!--<table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Process Type</th>
                <th>State</th>
                <th>ID</th>
                <th>Name</th>
                <th>Result Type</th>
                <th>ID</th>
                <th>Ent Type</th>
                <th>T State</th>
                <th>Executer</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat-start='st in entitytypes'>
                <td rowspan="[[st.transactions_types.length + st.transactions_types[0].ent_type.length]]">[[st.id]]</td>
                <td rowspan="[[st.transactions_types.length + st.transactions_types[0].ent_type.length]]">[[st.language[0].pivot.name]]</td>
                <td rowspan="[[st.transactions_types.length + st.transactions_types[0].ent_type.length]]">[[st.state]]</td>
                <td rowspan="[[st.transactions_types[0].ent_type.length]]">[[st.transactions_types[0].id]]</td>
                <td rowspan="[[st.transactions_types[0].ent_type.length]]">[[st.transactions_types[0].language[0].pivot.t_name]]</td>
                <td rowspan="[[st.transactions_types[0].ent_type.length]]">[[st.transactions_types[0].language[0].pivot.rt_name]]</td>
                <td>[[st.transactions_types[0].ent_type[0].id]]</td>
                <td>[[st.transactions_types[0].ent_type[0].language[0].pivot.name]]</td>
                <td>[[st.transactions_types[0].ent_type[0].t_states.language[0].pivot.name]]</td>
            </tr>
            <tr ng-repeat-end ng-repeat='test1 in st.transactions_types.ent_type' ng-hide="$first">
                <td>[[test1.id]]</td>
                <td>[[test1.language[0].pivot.name]]</td>
                <td>[[test1.t_states.language[0].pivot.rt_name]]</td>
            </tr>
            <tr ng-repeat='test in st.transactions_types' ng-hide="$first">
                <td rowspan="[[test.ent_type.length]]">[[test.id]]</td>
                <td rowspan="[[test.ent_type.length]]">[[test.language[0].pivot.t_name]]</td>
                <td rowspan="[[test.ent_type.length]]">[[test.language[0].pivot.rt_name]]</td>
            </tr>
            </tbody>
        </table>-->

        <!-- Table-to-load-the-data Part  -->
        <table class="table" ng-init="getEntityTypes()">
            <thead>
            <form ng-submit="filter()">
                <tr>
                    <th><input type="text" ng-model="search_process_type" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_result_type" class="form-control" placeholder="Type your search keyword.."></th>
                    <th>
                        <select class="form-control" ng-change="filter();" ng-model="search_state">
                            <option value=""></option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><input type="text" ng-model="search_executer" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="submit" /></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type_name.name',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type_name.t_name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.id',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type_name.name',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER5" | translate]] </th>
                <th>[[ "THEADER6" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.name',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER7" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.state',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER8" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.created_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER9" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.updated_at',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER10" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.deleted_at',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[[ "THEADER11" | translate]]</button></th>
            </tr>
{{--
            <tr>
                <th>Process Type</th>
                <th>Transaction Type</th>
                <th>ID</th>
                <th>Name</th>
                <th>Entity Type</th>
                <th>Transaction State</th>
                <th>State</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Deleted_at</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Adicionar Novo Tipo de Transacção</button></th>
            </tr>--}}
            </thead>
            <tbody>
            <tr ng-repeat="entitytype in entitytypes">
                {{--<td ng-show="[[entitytypes[$index - 1].transaction_type_id != entitytypes[$index].transaction_type_id]]">[[ entitytypes[$index].transactions_type.language[0].pivot.t_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id == entitytypes[$index].transaction_type_id]]"></td>

                <td>[[ entitytype.id ]]</td>
                <td>[[ entitytype.language[0].pivot.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ entitytype.ent_type.language[0].pivot.name ]]</td>
                <td>[[ entitytype.t_states.language[0].pivot.name ]]</td>
                <td>[[ entitytype.state ]]</td>
                <td>[[ entitytype.created_at ]]</td>
                <td>[[ entitytype.language[0].pivot.updated_at ]]</td>
                <td>[[ entitytype.deleted_at ]]</td>--}}

                <td ng-show="[[entitytypes[$index - 1].process_type_id != entitytypes[$index].process_type_id]]">[[ entitytypes[$index].process_type_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].process_type_id == entitytypes[$index].process_type_id]]"></td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id != entitytypes[$index].transaction_type_id]]">[[ entitytypes[$index].transaction_type_t_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id == entitytypes[$index].transaction_type_id]]"></td>

                <td>[[ entitytype.id ]]</td>
                <td>[[ entitytype.ent_type_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td></td>
                <td>[[ entitytype.t_state_name ]]</td>
                <td>[[ entitytype.state ]]</td>
                <td>[[ entitytype.created_at ]]</td>
                <td>[[ entitytype.updated_at ]]</td>
                <td>[[ entitytype.deleted_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', entitytype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(entitytype.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>
        <!-- End of Table-to-load-the-data Part -->
        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[ form_title | translate]]</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="entitytype.language[0].pivot.name">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">[[ "REQUIRED_FIELD" | translate:translationData]]</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputTransactionType" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_TYPE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.transaction_type_id" ng-options="item.id as item.language[0].pivot.t_name for item in transactiontypes">
                                        <option value="">[[ "INPUT_transaction_type_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="inputEntType" class="col-sm-3 control-label">[[ "INPUT_ENTITY_TYPE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.ent_type_id" ng-options="item.id as item.language[0].pivot.name for item in enttypes">
                                        <option value="">[[ "INPUT_entity_type_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="transactiontype_state" value="active" ng-model="entitytype.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="transactiontype_state" value="inactive" ng-model="entitytype.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.process_state.$invalid && frmTransactionTypes.process_state.$touched">State field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.t_state_id" ng-options="item.language[0].pivot.t_state_id as item.language[0].pivot.name for item in tstates">
                                        <option value="">[[ "INPUT_transaction_state_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.slug for item in langs">
                                        <option value="">[[ "INPUT_language_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                        <li>[[ error[0] ]]</li>
                                </ul>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/entTypes.js') ?>"></script>
@stop