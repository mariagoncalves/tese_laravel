@extends('layouts.default')
@section('content')
	<h2>{{ trans("relationTypes/messages.Page_Name") }}</h2>

    <div growl></div>
    
	<div ng-controller="RelationTypesManagmentControllerJs">
        <button type="button" class="btn btn-xs btn-success" ng-click="openModalRelTypes('md', 'add', 0)" style="margin-bottom: 10px; float: right;">
            Add Relations Type
        </button>

        <table ng-table="tableParams" ng-init="getRelationsTable()" class="table table-condensed table-bordered table-hover" show-filter="true">
            <tr ng-repeat="relType in tableParams.data">
                <td title="'Relation'" filter="{ relationFilter: 'text'}" sortable="'relation'" >[[ relType.relation ]]</td>
                <td title="'Entity 1'" filter="{ entity1Filter: 'text'}" sortable="'entity1'">[[ relType.entity1 ]]</td>
                <td title="'Entity 2'" filter="{ entity2Filter: 'text'}" sortable="'entity2'">[[ relType.entity2 ]]</td>
                <td title="'Transaction Type'" filter="{ transTypeFilter: 'text'}" sortable="'transaction_type'">[[ relType.transaction_type ]]</td>
                <td title="'Transaction State'" filter="{ transStateFilter: 'text'}" width="95px" sortable="'t_state_name'" >[[ relType.t_state_name ]]</td>
                <td title="'State'" filter="{ stateFilter: 'text'}" sortable="'state'" width="85px">[[ relType.state ]]</td>
                <td title="'Created'" sortable="'created_at'" width="90px">[[ relType.created_at ]]</td>
                <td title="'Action'">
                    <button class="btn btn-default btn-xs btn-warning" ng-click="openModalRelTypes('md', 'edit', relType.id)">Editar</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relType.id)" style="margin-top: 5px;">Remove</button>
                </td>
            </tr>
            <tr ng-if="tableParams.data.length == 0">
                <td colspan="8">Não existe relações...</td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/relTypes.js') ?>"></script>
@stop
