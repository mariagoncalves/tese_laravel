@extends('layouts.default')
@section('content')

	<h2>[["Page_Name" | translate]]</h2>

	<div ng-controller="RelationTypesManagmentControllerJs">
		<div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

		<table class="table table-striped" ng-init="getRelations()" border = "1px">
            <thead>
            <tr>
                <th>[[ "THEADER1" | translate]]</th>
                <th>[[ "THEADER2" | translate]]</th>
                <th>[[ "THEADER3" | translate]] 1</th>
                <th>[[ "THEADER3" | translate]] 2</th>
                <th>[[ "THEADER4" | translate]]</th>
                <th>[[ "THEADER5" | translate]]</th>
                <th>[[ "THEADER6" | translate]]</th>
                <th>[[ "THEADER7" | translate]]</th>
                <th>[[ "THEADER8" | translate]]</th>
                <!-- <th>[[ "THEADER9" | translate]]</th> -->
                <th> 
                    <!-- <button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">[[ "THEADER10" | translate]]</button> -->
                    <button type="button" class="btn btn-xs btn-success" ng-click="openModalRelTypes('md', 'add', 0)">Add Relations Type</button>
                </th>
            </tr> 
            </thead>
            <tbody>
                <td ng-if="relations.length == 0" colspan="10">[[ "NO_RELATIONS" | translate]]</td>

                <tr ng-repeat-start="relation in relations" ng-if="false" ng-init="innerIndex = $index"></tr>
                <td> [[ relation.id ]] </td>
                <td> [[ relation.language[0].pivot.name ]] </td>
                <td> [[ relation.ent1.language[0].pivot.name ]] </td>
                <td> [[ relation.ent2.language[0].pivot.name ]] </td>
                <td> [[ relation.transactions_type.language[0].pivot.t_name ]] </td>
                <td> [[ relation.t_state.language[0].pivot.name ]] </td>
                <td>[[ relation.state ]]</td>
                <td>[[ relation.created_at ]]</td>
                <td>[[ relation.updated_at ]]</td> 
                <!-- <td>[[ relation.deleted_at ]]</td> -->
                <td>
                    <!-- <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', relation.id)">[[ "BTNTABLE1" | translate]]</button> -->
                    <button type="button" class="btn btn-xs btn-warning" ng-click="openModalRelTypes('md', 'edit', relation.id)">Edit</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relation.id)">[[ "THEADER11" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>
                <tr ng-repeat-end ng-if="false"></tr>
            </tbody>
        </table> 
        <div>
            <pagination></pagination>
        </div>



        <!-- ______________________________________________TESTES _________________________________________________________-->


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
                <td sortable="'name'" filter="{name: 'text'}" data-title="'Relation'" groupable="'name'">
                    [[transactiontype.name]]
                </td>
                <td sortable="'id'" data-title="'ID'">
                    [[transactiontype.id]]
                </td>
                <td sortable="'t_name'" filter="{'t_name': 'text'}" data-title="'Entity 1'" groupable="'t_name'">
                    [[transactiontype.t_name]]
                </td>
                <td sortable="'rt_name'" data-title="'Entity 2'">
                    [[transactiontype.rt_name]]
                </td>

                <td sortable="'state'" data-title="'Transaction Type'" groupable="'state'">
                    [[transactiontype.state]]
                </td>

                <td sortable="'state'" data-title="'Transaction State'">
                    [[ transactiontype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'Created_at'">
                    [[ transactiontype.updated_at ]]
                </td>

                <td sortable="'deleted_at'" data-title="'Updated_at'">
                    [[ transactiontype.deleted_at ]]
                </td>

                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', transactiontype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(transactiontype.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>
        </table>


















        <!-- Modal (Pop up when detail button clicked) -->
        <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formRelation" name="formRel" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">[[ "THEADER2" | translate]]:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="relation_name" name="relation_name" ng-value="relation.language[0].pivot.name">
                                    <ul ng-repeat="error in errors.relation_name" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group" ng-init="getEntities()">
                                <label class="col-sm-3 control-label">[[ "THEADER3" | translate]] 1:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="entity_type1">
                                        <option value=""></option>
                                        <option ng-repeat="entity in entities" ng-value="entity.language[0].pivot.ent_type_id" ng-selected="entity.language[0].pivot.ent_type_id == relation.ent_type1_id">[[ entity.language[0].pivot.name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.entity_type1" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                                <br>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">[[ "THEADER3" | translate]] 2:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="entity_type2">
                                        <option value=""></option>
                                        <option ng-repeat="entity in entities" ng-value="entity.language[0].pivot.ent_type_id" ng-selected="entity.language[0].pivot.ent_type_id == relation.ent_type2_id">[[ entity.language[0].pivot.name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.entity_type2" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                                <br>
                            </div>

                            <div class="form-group" ng-init="getTransactionsTypes()">
                                <label class="col-sm-3 control-label">[[ "THEADER4" | translate]]:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="transactionsType">
                                        <option value=""></option>
                                        <option ng-repeat="transactionType in transactionTypes" ng-value="transactionType.language[0].pivot.transaction_type_id" ng-selected="transactionType.language[0].pivot.transaction_type_id == relation.transaction_type_id">[[ transactionType.language[0].pivot.t_name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.transactionsType" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                                <br>
                            </div>

                            <div class="form-group" ng-init="getTransactionsStates()">
                                <label class="col-sm-3 control-label">[[ "THEADER5" | translate]]:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="transactionsState">
                                        <option value=""></option>
                                        <option ng-repeat="transactionState in transactionStates" ng-value="transactionState.language[0].pivot.t_state_id" ng-selected="transactionState.language[0].pivot.t_state_id == relation.t_state_id">[[ transactionState.language[0].pivot.name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.transactionsState" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                                <br>
                            </div>

                            <div class="form-group" ng-init="getStates()">
                                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER6" | translate]]:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline state" ng-repeat="state in states">
                                        <input type="radio" name="relation_state" value="[[ state ]]" ng-checked="state == relation.state">[[ state ]]
                                    </label>
                                    <ul ng-repeat="error in errors.relation_state" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formRelation.$invalid">[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div> -->

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/relTypes.js') ?>"></script>
@stop
