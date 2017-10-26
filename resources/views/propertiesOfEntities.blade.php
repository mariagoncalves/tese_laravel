@extends('layouts.default')
@section('content')
    <h2>{{trans("properties/messages.Page_Name")}}</h2>
    <div ng-controller="propertiesOfEntitiesManagmentControllerJs">
        <!-- <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <table class="table table-striped" st-table="displayedCollection" ng-init="getEntities()" st-safe-src="entities">
            <thead>
            <tr>

                <th> [[ "THEADER1" | translate]] </th>
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

                <th> 
                    
                    <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsEnt('md', 'add', 0)">Add Properties</button>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat-start="entity in displayedCollection" ng-if="false" ng-init="innerIndex = $index"></tr>

                <td rowspan="[[ entity.properties.length + 1 ]] " ng-if="entity.properties[$index - 1].rel_type_id != entity.id">
                    [[ entity.language[0].pivot.name ]]

                    <div ng-if="entity.properties.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(entity.id)">[[ "BTNTABLE3" | translate]]</button>
                    </div>
                </td>

                <td ng-if="entity.properties.length == 0" colspan="11">[[ "NO_PROPERTIES" | translate]]</td>
                <td ng-if="entity.properties.length == 0" colspan="1">
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>

                <tr ng-repeat="property in entity.properties">
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
                    <td>
                        <button type="button" class="btn btn-xs btn-warning" ng-click="openModalPropsEnt('md', 'edit', property.id)">Edit</button>
                        <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(property.id)">[[ "BTNTABLE4" | translate]]</button>
                        <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    </td>
                    <tr ng-repeat-end ng-if="false"></tr>
                </tr>
            </tbody>
        </table>
        <div>
            <pagination></pagination>
        </div> -->

        <!-- ______________________________________________TESTES _________________________________________________________-->


        <!-- <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsEnt('md', 'add', 0)">{{trans('properties/messages.ADD_PROPERTIES')}}</button>
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
            <tr ng-hide="group.$hideRows" ng-repeat="entity in group.data" ng-repeat-end>
                <td sortable="'entity'" data-title="'{{trans('properties/messages.THEADER2')}}'">
                    [[entity.language[0].pivot.name]]
                    <div ng-if="entity.properties.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(entity.id)">[[ "BTNTABLE3" | translate]]</button>
                    </div>
                </td>
                <td sortable="'id'" data-title="'{{trans('properties/messages.THEADER1')}}'">
                    [[]]
                </td>
                <td sortable="'property'" data-title="'{{trans('properties/messages.THEADER3')}}'">
                    [[property.language[0].pivot.name]]
                </td>
                <td sortable="'value_type'" data-title="'{{trans('properties/messages.THEADER4')}}'">
                    [[property.value_type]]
                </td>
                <td sortable="'form_field_name'" data-title="'{{trans('properties/messages.THEADER5')}}'">
                    [[property.form_field_name]]
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
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalPropsEnt('md', 'edit', property.id)">{{trans('properties/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-info btn-xs btn-delete">{{trans('properties/messages.BTNTABLE2')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(property.id)">{{trans('properties/messages.BTNTABLE4')}}</button>
                </td>
            </tr> 
        </table> -->


        <!-- NG TABLE RECENTE -->

        <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsEnt('md', 'add', 0)">{{trans('properties/messages.ADD_PROPERTIES')}}</button>
        <br>
        <br>

        <table ng-table="tableParams" ng-init="getPropsOfEntities()" class="table table-condensed table-bordered table-hover" show-filter="true">
            <tr ng-repeat="entitiesProps in tableParams.data">
                <td title="'Entity'" filter ="{entityFilter: 'text'}" sortable="'entity_name'" >
                    [[entitiesProps.entity_name]]
                    <div>
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindow(entitiesProps.id)"> [[ "BTNTABLE3" | translate]]</button>
                    </div>
                </td>
                <td title="'{{trans('properties/messages.THEADER1')}}'" sortable="'id'" > [[entitiesProps.id]] </td>
                <td title="'{{trans('properties/messages.THEADER3')}}'" filter ="{propertyFilter: 'text'}" sortable="'property_name'" > [[entitiesProps.property_name]] </td>
                <td title="'{{trans('properties/messages.THEADER4')}}'" sortable="'value_type'" > [[entitiesProps.value_type]] </td>
                <td title="'{{trans('properties/messages.THEADER5')}}'" sortable="'form_field_name'" > [[entitiesProps.form_field_name]] </td>
                <td title="'{{trans('properties/messages.THEADER6')}}'" sortable="'form_field_type'" > [[entitiesProps.form_field_type]] </td>
                <td title="'{{trans('properties/messages.THEADER7')}}'" sortable="'unit_type'" > [[entitiesProps.unit_type]] </td>
                <td title="'{{trans('properties/messages.THEADER8')}}'" sortable="'form_field_size'" > [[entitiesProps.form_field_size]] </td>
                <td title="'{{trans('properties/messages.THEADER9')}}'" sortable="'mandatory'" > [[ entitiesProps.mandatory ]] </td>
                <td title="'{{trans('properties/messages.THEADER10')}}'" sortable="'state'" > [[ entitiesProps.state ]] </td>
                <td title="'{{trans('properties/messages.THEADER11')}}'" sortable="'created_at'" > [[ entitiesProps.created_at ]] </td>
                <td title="'{{trans('properties/messages.THEADER12')}}'" sortable="'updated_at'" > [[ entitiesProps.updated_at ]] </td>
                <td title="'Action'">
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalPropsEnt('md', 'edit', entitiesProps.id)">{{trans('properties/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-info btn-xs btn-delete">{{trans('properties/messages.BTNTABLE2')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(relation.id)">{{trans('properties/messages.BTNTABLE4')}}</button>
                </td>
            </tr> 
        </table>


        <!-- Popup para reordenar as propriedades -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.FORM_DRAG_DROP')}}</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('properties/messages.Page_Name')}}</h4>
                        <ul ui-sortable="sortableOptionsEnt" ng-model="propsEnt" class="list-group">
                            <li ng-repeat="prop in propsEnt" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
                        </ul>

                       <!-- <pre>[[propsEnt]]</pre> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propertiesOfEntities.js') ?>"></script>
@stop
