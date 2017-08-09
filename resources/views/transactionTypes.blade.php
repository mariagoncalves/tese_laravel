@extends('layouts.default')
@section('content')
    <div ng-controller="transactionTypesController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover">
            <colgroup>
                <col width="60%" />
                <col width="20%" />
                <col width="20%" />
            </colgroup>
            <tr class="ng-table-group" ng-repeat-start="group in $groups">
                <td colspan="1">
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                        <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                        <strong>[[ group.value ]]</strong>
                    </a>
                </td>
            </tr>
            <tr ng-hide="group.$hideRows" ng-repeat="transactiontype in group.data" ng-repeat-end>
                <td sortable="'name'" filter="{name: 'text'}" data-title="'THEADER5' | translate" groupable="'name'">
                    [[transactiontype.name]]
                </td>
                <td sortable="'id'" data-title="'ID'">
                    [[transactiontype.id]]
                </td>
                <td sortable="'t_name'" filter="{'t_name': 'text'}" data-title="'THEADER2' | translate" groupable="'t_name'">
                    [[transactiontype.t_name]]
                </td>
                <td sortable="'rt_name'" data-title="'THEADER3' | translate" groupable="'rt_name'">
                    [[transactiontype.rt_name]]
                </td>

                <td sortable="'state'" data-title="'State'" groupable="'state'">
                    [[transactiontype.state]]
                </td>

                <td sortable="'state'" data-title="'Created_at'">
                    [[ transactiontype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'Updated_at'">
                    [[ transactiontype.updated_at ]]
                </td>

                <td sortable="'deleted_at'" data-title="'Deleted_at'">
                    [[ transactiontype.deleted_at ]]
                </td>

                <td sortable="'executer'" data-title="'Executer'">
                    [[ transactiontype.executer ]]
                </td>

                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', transactiontype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(transactiontype.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>
        </table>

        <!--<table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Process Type</th>
                <th>State</th>
                <th>ID</th>
                <th>Name</th>
                <th>Result Type</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Deleted_at</th>
                <th>Executer</th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat-start='st in transactiontypes'>
                    <td rowspan="[[st.transactions_types.length]]">[[st.id]]</td>
                    <td rowspan="[[st.transactions_types.length]]">[[st.language[0].pivot.name]]</td>
                    <td rowspan="[[st.transactions_types.length]]">[[st.state]]</td>
                    <td>[[st.transactions_types[0].id]]</td>
                    <td>[[st.transactions_types[0].language[0].pivot.t_name]]</td>
                    <td>[[st.transactions_types[0].language[0].pivot.rt_name]]</td>
                    <td>[[st.transactions_types[0].executer_actor.language[0].pivot.name]]</td>
                </tr>
                <tr ng-repeat-end ng-repeat='test in st.transactions_types' ng-hide="$first">
                    <td>[[test.id]]</td>
                    <td>[[test.language[0].pivot.t_name]]</td>
                    <td>[[test.language[0].pivot.rt_name]]</td>
                    <td>[[test.executer_actor.language[0].pivot.name]]</td>
                </tr>
            </tbody>
        </table>-->

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getTransacsTypes()">
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
                <th>[[ "THEADER5" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type_name.name',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type.id',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type_name.t_name',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type_name.rt_name',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type.state',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER7" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type.created_at',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER8" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type.updated_at',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER9" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type.deleted_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER6" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('actor_name.name',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[[ "THEADER10" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="transactiontype in transactiontypes">
                    {{--<td ng-show="[[transactiontypes[$index - 1].process_type_id != transactiontypes[$index].process_type_id]]">[[ transactiontypes[$index].process_type.language[0].pivot.name ]]</td>
                    <td ng-show="[[transactiontypes[$index - 1].process_type_id == transactiontypes[$index].process_type_id]]"></td>
                    <td>[[  transactiontype.id ]]</td>
                    <td>[[ transactiontype.language[0].pivot.t_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                    <td>[[ transactiontype.language[0].pivot.rt_name ]]</td>
                    <td>[[ transactiontype.state ]]</td>
                    <td>[[ transactiontype.created_at ]]</td>
                    <td>[[ transactiontype.language[0].pivot.updated_at ]]</td>
                    <td>[[ transactiontype.deleted_at ]]</td>
                    <td>[[ transactiontype.executer_actor.language[0].pivot.name ]]</td>--}}
                    <td ng-show="[[transactiontypes[$index - 1].process_type_id != transactiontypes[$index].process_type_id]]">[[ transactiontypes[$index].name ]]</td>
                    <td ng-show="[[transactiontypes[$index - 1].process_type_id == transactiontypes[$index].process_type_id]]"></td>
                    <td>[[  transactiontype.id ]]</td>
                    <td>[[ transactiontype.t_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                    <td>[[ transactiontype.rt_name ]]</td>
                    <td>[[ transactiontype.state ]]</td>
                    <td>[[ transactiontype.created_at ]]</td>
                    <td>[[ transactiontype.updated_at ]]</td>
                    <td>[[ transactiontype.deleted_at ]]</td>
                    <td>[[ transactiontype.executer ]]</td>
                    <td>
                        <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', transactiontype.id)">[[ "BTNTABLE1" | translate]]</button>
                        <button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                        <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(transactiontype.id)">[[ "BTNTABLE3" | translate]]</button>
                    </td>
                </tr>
            {{--<tr ng-repeat="transactiontype in transactiontypes">
                <td ng-show="[[transactiontypes[$index - 1].process_type_id != transactiontypes[$index].process_type_id]]">[[ transactiontypes[$index].name ]]</td>
                <td ng-show="[[transactiontypes[$index - 1].process_type_id == transactiontypes[$index].process_type_id]]"></td>
                <td>[[  transactiontype.id ]]</td>
                <td>[[ transactiontype.t_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ transactiontype.rt_name ]]</td>
                <td>[[ transactiontype.state ]]</td>
                <td>[[ transactiontype.created_at ]]</td>
                <td>[[ transactiontype.updated_at ]]</td>
                <td>[[ transactiontype.deleted_at ]]</td>
                <td>[[ transactiontype.executer ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', transactiontype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(transactiontype.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>--}}
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
                                   ng-model="transactiontype.language[0].pivot.t_name" required>
                            <div ng-messages="frmTransactionTypes.transactiontype_t_name.$error" ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">
                                <p ng-message="required">Providing a name is mandatory.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputResultType" class="col-sm-3 control-label">[[ "INPUT_RESULT_TYPE" | translate]]</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="transactiontype_rt_name" name="transactiontype_rt_name" placeholder=""
                                   ng-model="transactiontype.language[0].pivot.rt_name" required>
                           <div ng-messages="frmTransactionTypes.transactiontype_rt_name.$error" ng-show="frmTransactionTypes.transactiontype_rt_name.$invalid && frmTransactionTypes.transactiontype_rt_name.$touched">
                                <p ng-message="required">Providing a result type is mandatory.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_PROCESS_TYPE" | translate]]</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="transaction_type_process_type" ng-model="transactiontype.process_type_id" ng-options="item.id as item.language[0].pivot.name for item in processtypes" required>
                                <option value="">[[ "INPUT_process_type_id" | translate]]</option>
                            </select>
                            <div ng-messages="frmTransactionTypes.transaction_type_process_type.$error" ng-show="frmTransactionTypes.transaction_type_process_type.$invalid && frmTransactionTypes.transaction_type_process_type.$touched">
                                <p ng-message="required">Providing a process type is mandatory.</p>
                            </div>
                        </div>
                        <br>
                        <ul ng-repeat="error in errors">
                            <li>[[ error[0] ]]</li>
                        </ul>

                    </div>

                    <div class="form-group">
                        <label for="state" class="col-sm-3 control-label">[[ "INPUT_STATE" | translate]]</label>
                        <div class="col-sm-9">
                            <label for="" class="radio-inline state">
                                <input type="radio" name="transactiontype_state" value="active" ng-model="transactiontype.state" required>Active
                            </label>
                            <label for="" class="radio-inline state">
                                <input type="radio" name="transactiontype_state" value="inactive" ng-model="transactiontype.state" required>Inactive
                            </label>
                            <div ng-messages="frmTransactionTypes.transactiontype_state.$error" ng-show="frmTransactionTypes.transactiontype_state.$invalid && frmTransactionTypes.transactiontype_state.$touched">
                                <p ng-message="required">Providing a state is mandatory.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="executer" class="col-sm-3 control-label">[[ "INPUT_EXECUTER" | translate]]</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="transactiontype_executer" ng-model="transactiontype.executer_actor.language[0].pivot.actor_id" ng-options="item.language[0].pivot.actor_id as item.language[0].pivot.name for item in executers" required>
                                <option value="">[[ "INPUT_executer_id" | translate]]</option>
                            </select>
                            <div ng-messages="frmTransactionTypes.transactiontype_executer.$error" ng-show="frmTransactionTypes.transactiontype_executer.$invalid && frmTransactionTypes.transactiontype_executer.$touched">
                                <p ng-message="required">Providing a executer is mandatory.</p>
                            </div>
                        </div>
                        <br>
                        <ul ng-repeat="error in errors">
                            <li>[[ error[0] ]]</li>
                        </ul>

                    </div>

                    <div class="form-group">
                        <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="transactiontype_language_id" ng-model="transactiontype.language[0].id" ng-options="item.id as item.slug for item in langs" required>
                                <option value="">[[ "INPUT_language_id" | translate]]</option>
                            </select>
                            <div ng-messages="frmTransactionTypes.transactiontype_language_id.$error" ng-show="frmTransactionTypes.transactiontype_language_id.$invalid && frmTransactionTypes.transactiontype_language_id.$touched">
                                <p ng-message="required">Providing a language is mandatory.</p>
                            </div>
                        </div>
                        <br>
                        <ul ng-repeat="error in errors">
                                <li>[[ error[0] ]]</li>
                        </ul>

                    </div>
                </form>
            </div>
            <div class="modal-footer"><!--  -->
                <button type="button" ng-disabled="frmTransactionTypes.$invalid" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('footerContent')
<script src="<?= asset('app/controllers/transactionTypes.js') ?>"></script>
@stop