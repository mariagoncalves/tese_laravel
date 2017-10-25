@extends('layouts.default')
@section('content')

	<h2>{{trans("relationTypes/messages.Page_Name")}}</h2>

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

        <button type="button" class="btn btn-xs btn-success" ng-click="openModalRelTypes('md', 'add', 0)">{{trans('relationTypes/messages.THEADER10')}}</button>
        <br>
        <br>

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
            <tr ng-hide="group.$hideRows" ng-repeat="relation in group.data" ng-repeat-end>
                <td sortable="'name'" filter="{name: 'text'}" data-title="'{{trans('relationTypes/messages.THEADER4')}}'" groupable="'name'">
                    [[relation.transactions_type.language[0].pivot.t_name]]
                </td>
                <td sortable="'id'" data-title="'{{trans('relationTypes/messages.THEADER1')}}'">
                    [[relation.id]]
                </td>
                <td sortable="'language[0].pivot.name'" filter="{'language[0].pivot.name': 'text'}" data-title="'{{trans('relationTypes/messages.THEADER2')}}'" groupable="'language[0].pivot.name'">
                    [[relation.language[0].pivot.name]]
                </td>

                <td sortable="'ent_type1_id'" data-title="'{{trans('relationTypes/messages.THEADER3')}} 1'" groupable="'ent_type1_id'">
                    [[relation.ent1.language[0].pivot.name]]
                </td>

                <td sortable="'ent_type2_id'" data-title="'{{trans('relationTypes/messages.THEADER3')}} 2'" groupable="'ent_type2_id'">
                    [[relation.ent2.language[0].pivot.name]]
                </td>

                <td sortable="'t_state'" data-title="'{{trans('relationTypes/messages.THEADER5')}}'">
                    [[ relation.t_state.language[0].pivot.name ]]
                </td>

                <td sortable="'state'" data-title="'State'" groupable="'{{trans('relationTypes/messages.THEADER6')}}'">
                    [[ relation.state ]]
                </td>

                <td sortable="'created_at'" data-title="'{{trans('relationTypes/messages.THEADER7')}}'">
                    [[ relation.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'{{trans('relationTypes/messages.THEADER8')}}'">
                    [[ relation.updated_at ]]
                </td>

                <td>
                    <button type="button" class="btn btn-xs btn-warning" ng-click="openModalRelTypes('md', 'edit', relation.id)">{{trans('relationTypes/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relation.id)">{{trans('relationTypes/messages.THEADER11')}}</button>
                    <button class="btn btn-primary btn-xs btn-delete">{{trans('relationTypes/messages.BTNTABLE2')}}</button>
                </td>
            </tr>
            </tr>
        </table>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/relTypes.js') ?>"></script>
@stop
