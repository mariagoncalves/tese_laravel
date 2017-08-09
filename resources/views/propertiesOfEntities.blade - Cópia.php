@extends('layouts.default')
@section('content')
    <h2>{{trans("messages.properties")}}</h2>
    <div ng-controller="propertiesManagmentControllerJs">
        <div growl></div>
        <!-- Table-to-load-the-data Part -->
        <table class="table table-striped" st-table="displayedCollection" ng-init="getEntities()" st-safe-src="entities">
            <thead>
            <tr>
                <th st-sort="language[0].pivot.name">{{trans("messages.entity")}}</th>
                <th>ID</th>
                <th>{{trans("messages.property")}}</th>
                <th>{{trans("messages.valueType")}}</th>
                <th>{{trans("messages.formFieldName")}}</th>
                <th>{{trans("messages.formFieldType")}}</th>
                <th>{{trans("messages.unitType")}}</th>
                <!-- <th>{{trans("messages.formFieldOrder")}}</th> -->
                <th>{{trans("messages.formFieldSize")}}</th>
                <th>{{trans("messages.mandatory")}}</th>
                <th>{{trans("messages.state")}}</th>
                <th>{{trans("messages.updated_on")}}</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">{{trans("messages.addProperties")}}</button></th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat-start="entity in displayedCollection" ng-if="false" ng-init="innerIndex = $index"></tr>

                <td rowspan="[[ entity.properties.length + 1 ]] " ng-if="entity.properties[$index - 1].rel_type_id != entity.id">
                    [[ entity.language[0].pivot.name ]]

                    <div ng-if="entity.properties.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(entity.id)"> {{trans("messages.buttonDragDrop")}}</button>
                    </div>
                </td>

                <td ng-if="entity.properties.length == 0" colspan="10">{{trans("messages.noProperties")}}</td>
                <td ng-if="entity.properties.length == 0" colspan="1">
                    <!--<button class="btn btn-default btn-xs btn-detail">Inserir</button> -->
                    <button class="btn btn-danger btn-xs btn-delete">{{trans("messages.history")}}</button>
                </td>

                <tr ng-repeat="property in entity.properties">
                    <td>[[ property.id ]]</td>
                    <td>[[ property.language[0].pivot.name ]]</td>
                    <td>[[ property.value_type ]]</td>
                    <td>[[ property.language[0].pivot.form_field_name ]]</td>
                    <td>[[ property.form_field_type ]]</td>
                    <td>[[ property.units ? property.units.language[0].pivot.name : '-' ]]</td>
                    <!-- <td>[[ property.form_field_order ]]</td> -->
                    <td>[[ property.form_field_size != null ? property.form_field_size : '-']]</td>
                    <td>[[ (property.mandatory == 1) ? 'Yes' : 'No' ]]</td>
                    <td>[[ property.state ]]</td>
                    <td>[[ property.updated_at ]]</td>
                    <td>
                        <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', property.id)">{{trans("messages.edit")}}</button>
                        <button class="btn btn-danger btn-xs btn-delete">{{trans("messages.history")}}</button>
                    </td>
                    <tr ng-repeat-end ng-if="false"></tr>
                </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>

        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[form_title]]</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formProperty" name="frmProp" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{trans("messages.entityType")}}:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="entity_type">
                                        <option value=""></option>
                                        <option ng-repeat="entity in entities" ng-value="entity.id" ng-selected="entity.id == property.ent_type_id">[[ entity.language[0].pivot.name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.entity_type" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                                <br>
                            </div>

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">{{trans("messages.propertyName")}}:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="property_name" name="property_name" ng-value="property.language[0].pivot.name">
                                    <ul ng-repeat="error in errors.property_name" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group" ng-init="getStates()">
                                <label for="Gender" class="col-sm-3 control-label">{{trans("messages.state")}}:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline state" ng-repeat="state in states">
                                        <input type="radio" name="property_state" value="[[ state ]]" ng-checked="state == property.state">[[ state ]]
                                    </label>
                                    <ul ng-repeat="error in errors.property_state" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group" ng-init="getValueTypes()">
                                <label for="Gender" class="col-sm-3 control-label">{{trans("messages.valueType")}}:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline valueType" ng-repeat="valueType in valueTypes">
                                        <input type="radio" name="property_valueType" value="[[ valueType ]]" ng-checked="valueType == property.value_type" >[[ valueType ]]
                                    </label>
                                    <ul ng-repeat="error in errors.property_valueType" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group" ng-init="getFieldTypes()">
                                <label for="Gender" class="col-sm-3 control-label">{{trans("messages.formFieldType")}}:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline fieldType" ng-repeat="fieldType in fieldTypes">
                                        <input type="radio" name="property_fieldType" value="[[ fieldType ]]" ng-checked="fieldType == property.form_field_type" >[[ fieldType ]]
                                    </label>
                                    <ul ng-repeat="error in errors.property_fieldType" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group" ng-init="getUnits()">
                                <label for="unitType" class="col-sm-3 control-label">{{trans("messages.unitType")}}:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="unites_names">
                                        <option value="0"></option>
                                        <option ng-repeat="unit in units" ng-value="unit.id" ng-selected="unit.id == property.unit_type_id">[[ unit.language[0].pivot.name ]]</option>
                                    </select>
                                    <ul ng-repeat="error in errors.unites_names" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label for="inputfieldOrder" class="col-sm-3 control-label">{{trans("messages.fieldOrder")}}:</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="property_fieldOrder" name="property_fieldOrder" ng-value="property.form_field_order" >
                                    <ul ng-repeat="error in errors.property_fieldOrder" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div> -->

                           <div class="form-group">
                                <label for="inputfieldSize" class="col-sm-3 control-label">{{trans("messages.fieldSize")}}:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="property_fieldSize" name="property_fieldSize"  ng-value="property.form_field_size">
                                    <ul ng-repeat="error in errors.property_fieldSize" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">{{trans("messages.mandatory")}}:</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline mandatory">
                                        <input type="radio" name="property_mandatory" value="1" ng-checked="1 == property.mandatory" required>Yes
                                    </label>
                                    <label for="" class="radio-inline mandatory">
                                        <input type="radio" name="property_mandatory" value="0" ng-checked="0 == property.mandatory" required>No
                                    </label>
                                    <ul ng-repeat="error in errors.property_mandatory" style="padding-left: 15px;">
                                        <li>[[ error ]]</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="entityType" class="col-sm-3 control-label">{{trans("messages.refEntity")}}:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="reference_entity">
                                        <option value="0"></option>
                                        <option ng-repeat="entity in entities" ng-value="entity.id" ng-selected="entity.id == property.fk_ent_type_id">[[ entity.language[0].pivot.name ]]</option>
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmProp.$invalid">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup para reordenar as propriedades -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[form_title]]</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans("messages.properties")}}</h4>
                        <ul ui-sortable="sortableOptionsEnt" ng-model="propsEnt" class="list-group">
                            <li ng-repeat="prop in propsEnt" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
                        </ul>

                       <pre>[[propsEnt]]</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/properties.js') ?>"></script>
@stop
