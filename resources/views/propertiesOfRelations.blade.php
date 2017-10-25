@extends('layouts.default')
@section('content')
    <h2>[["Page_Name" | translate]]</h2>
    <!-- <div ng-controller="propertiesManagmentControllerJs"> -->
    <div ng-controller="propertiesOfRelationsManagmentControllerJs">
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <!-- Table-to-load-the-data Part -->
        <table class="table table-striped" st-table="displayedCollection" ng-init="getRelations()" st-safe-src="relations">
            <thead>
            <tr>
                <!-- <th st-sort="language[0].pivot.name">{{trans("messages.relation")}}</th>
                <th>ID</th>
                <th>{{trans("messages.property")}}</th>
                <th>{{trans("messages.valueType")}}</th>
                <th>{{trans("messages.formFieldName")}}</th>
                <th>{{trans("messages.formFieldType")}}</th>
                <th>{{trans("messages.unitType")}}</th>
                <th>{{trans("messages.formFieldSize")}}</th>
                <th>{{trans("messages.mandatory")}}</th>
                <th>{{trans("messages.state")}}</th>
                <th>{{trans("messages.updated_on")}}</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggleRel('add', 0)">{{trans("messages.addProperties")}}</button></th> -->

                <th> [[ "THEADER15" | translate]] </th>
                <th> [[ "THEADER2" | translate]] </th>
                <th> [[ "THEADER3" | translate]] </th>
                <th> [[ "THEADER4" | translate]] </th>
                <th> [[ "THEADER5" | translate]] </th>
                <th> [[ "THEADER6" | translate]] </th>
                <th> [[ "THEADER7" | translate]] </th>
                <th> [[ "THEADER8" | translate]] </th>
                <th> [[ "THEADER9" | translate]] </th>
                <th> [[ "THEADER10" | translate]] </th>
                <th> [[ "THEADER11" | translate]] </th>
                <th> [[ "THEADER12" | translate]] </th>
                <!-- <th> [[ "THEADER13" | translate]] </th> -->
                <th> 
                    <!-- <button id="btn-add" class="btn btn-success btn-xs" ng-click="toggleRel('add', 0)">[[ "THEADER14" | translate]]</button> -->
                    <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsRel('md', 'add', 0)">Add Properties</button>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat-start="relation in displayedCollection" ng-if="false" ng-init="innerIndex = $index"></tr>

                <td rowspan="[[ relation.properties.length + 1 ]] " ng-if="relation.properties[$index - 1].ent_type_id != relation.id">
                    [[ relation.language[0].pivot.name ]]

                    <div ng-if="relation.properties.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindow(relation.id)"> [[ "BTNTABLE3" | translate]]</button>
                    </div>
                </td>

                <td ng-if="relation.properties.length == 0" colspan="11">[[ "NO_PROPERTIES" | translate]]</td>
                <td ng-if="relation.properties.length == 0" colspan="1">
                    <!-- <button class="btn btn-default btn-xs btn-detail">Inserir</button> -->
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>

                <tr ng-repeat="property in relation.properties">
                    <td>[[ property.id ]]</td>
                    <td>[[ property.language[0].pivot.name ]]</td>
                    <td>[[ property.value_type ]]</td>
                    <td>[[ property.language[0].pivot.form_field_name ]]</td>
                    <td>[[ property.form_field_type ]]</td>
                    <td>[[ property.units ? property.units.language[0].pivot.name : '-' ]]</td>
                    <td>[[ property.form_field_size != null ? property.form_field_size : '-']]</td>
                    <td>[[ (property.mandatory == 1) ? 'Yes' : 'No' ]]</td>
                    <td>[[ property.state ]]</td>
                    <td>[[ property.created_at ]]</td>
                    <td>[[ property.updated_at ]]</td>
                    <!-- <td>[[ property.deleted_at ]]</td> -->
                    <td>
                        <!-- <button class="btn btn-warning btn-xs btn-detail" ng-click="toggleRel('edit', property.id)">[[ "BTNTABLE1" | translate]]</button> -->
                        <button type="button" class="btn btn-xs btn-warning" ng-click="openModalPropsRel('md', 'edit', property.id)">Edit</button>
                        <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relation.id)">[[ "BTNTABLE4" | translate]]</button>
                        <button class="btn btn-danger btn-xs btn-delete" ng-click="openModaConfirm('md', property.id)"> REMOVER </button>
                        <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    </td>
                    <tr ng-repeat-end ng-if="false"></tr>
                </tr>
            </tbody>
        </table>
        <div>
            <pagination></pagination>
        </div>


        <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsRel('md', 'add', 0)">{{trans('properties/messages.ADD_PROPERTIES')}}</button>
        <br>
        <br>

        <!-- Tabela utilizando o ng-table -->
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
                <!-- <td sortable="'name'" filter="{name: 'text'}" data-title="'Relation" groupable="'name'">
                    [[relation.language[0].pivot.name]]
                </td> -->
                <td sortable="'relation'" data-title="'{{trans('properties/messages.THEADER13')}}'">
                    [[relation.language[0].pivot.name]]
                    <div ng-if="relation.properties.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindow(relation.id)"> [[ "BTNTABLE3" | translate]]</button>
                    </div>
                </td>
                <td sortable="'id'" data-title="'{{trans('properties/messages.THEADER1')}}'">
                    [[transactiontype.id]]
                </td>
                <td sortable="'property'" data-title="'{{trans('properties/messages.THEADER3')}}'">
                    [[transactiontype.id]]
                </td>
                <td sortable="'value_type'" data-title="'{{trans('properties/messages.THEADER4')}}'">
                    [[transactiontype.value_type]]
                </td>
                <td sortable="'form_field_name'" data-title="'{{trans('properties/messages.THEADER5')}}'">
                    [[transactiontype.form_field_name]]
                </td>
                <td sortable="'form_field_type'" data-title="'{{trans('properties/messages.THEADER6')}}'">
                    [[transactiontype.form_field_type]]
                </td>
                <td sortable="'unit_type'" data-title="'{{trans('properties/messages.THEADER7')}}'">
                    [[transactiontype.unit_type]]
                </td>

                <td sortable="'form_field_size'" data-title="'{{trans('properties/messages.THEADER8')}}'">
                    [[transactiontype.form_field_size]]
                </td>

                <td sortable="'mandatory'" data-title="'{{trans('properties/messages.THEADER9')}}'">
                    [[ transactiontype.mandatory ]]
                </td>

                <td sortable="'state'" data-title="'{{trans('properties/messages.THEADER10')}}'">
                    [[ transactiontype.state ]]
                </td>

                <td sortable="'created_at'" data-title="'{{trans('properties/messages.THEADER11')}}'">
                    [[ transactiontype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'{{trans('properties/messages.THEADER12')}}'">
                    [[ transactiontype.updated_at ]]
                </td>

                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalPropsRel('md', 'edit', property.id)">{{trans('properties/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-info btn-xs btn-delete">{{trans('properties/messages.BTNTABLE2')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(relation.id)">{{trans('properties/messages.BTNTABLE4')}}</button>
                </td>
            </tr> 
        </table>

        <!-- Popup para reordenar propriedades-->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.FORM_DRAG_DROP')}}</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('properties/messages.Page_Name')}}</h4>
                        <ul ui-sortable="sortableOptions" ng-model="propsRel" class="list-group">
                            <li ng-repeat="prop in propsRel" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
                        </ul>
                       <!-- <pre>[[propsRel]]</pre> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Popup para confirmar a remoção da relação -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.REMOVE_PROPERTY')}}</h4>
                    </div>

                    <div class="modal-body">
                        <p>{{trans('properties/messages.REMOVE_MESSAGE')}}</p>
                        <button class="btn btn-primary btn-xs btn-primary" ng-click="remove(property.id)"> {{trans('properties/messages.YES')}} </button>
                        <button class="btn btn-primary btn-xs btn-primary" ng-click=""> {{trans('properties/messages.NO')}} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propertiesOfRelations.js') ?>"></script>
@stop
