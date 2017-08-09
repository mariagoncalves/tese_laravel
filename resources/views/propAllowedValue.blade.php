@extends('layouts.default')
@section('content')
    <div ng-controller="propAllowedValueController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>
        <table class="table table-striped" st-table="displayedCollection" ng-init="getPropAllowedValues()" st-safe-src="propAllowedValues">
            <thead>
            <tr>
                <th st-sort="language[0].pivot.name">[["THEADER1" | translate]]</th>
                <th>[["THEADER2" | translate]]</th>
                <th st-sort="properties.language[0].pivot.name">[["THEADER3" | translate]]</th>
                <th>[["THEADER4" | translate]]</th>
                <th>[["THEADER5" | translate]]</th>
                <th>[["THEADER6" | translate]]</th>
                <th></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[["THEADER7" | translate]]</button></th>
                <th></th>
            </tr>
            <tr>
                <th colspan="7">
                    <input st-search="" class="form-control" placeholder="Search ..." type="text"/>
                </th>
            </tr>
            </thead>
            <tbody>

            <tr ng-repeat-start="allowed_value in displayedCollection" ng-if="false" ng-init="innerIndex = $index"></tr>
            <tr ng-repeat-start="property in allowed_value.properties" ng-if="false"></tr>
			
            <td rowspan="[[ property.prop_allowed_values.length + 1 ]] " ng-if="allowed_value.properties[$index - 1].ent_type_id != property.ent_type_id">[[ allowed_value.language[0].pivot.name ]] </td>
            <td rowspan="[[ property.prop_allowed_values.length + 1 ]] " ng-if="allowed_value.properties[$index - 1].ent_type_id == property.ent_type_id"> </td>

            <td rowspan="[[ property.prop_allowed_values.length + 1 ]]">[[ property.id ]]</td>
            <td rowspan="[[ property.prop_allowed_values.length + 1 ]]">[[ property.language[0].pivot.name ]]</td>
            <td ng-if="property.prop_allowed_values.length == 0" colspan="4"> [["THEADER_EMPTY_VALUES" | translate]] </td>

            <tr ng-repeat="prop_allowed_value in property.prop_allowed_values">
                <td>[[ prop_allowed_value.id ]]</td>
                <td>[[ prop_allowed_value.language[0].pivot.name ]]</td>
                <td>[[ prop_allowed_value.state ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', prop_allowed_value.id, property.id)">Editar</button>
                    <button class="btn btn-danger btn-xs btn-delete">[["BTNTABLE2" | translate]]</button>
                </td>

            <tr ng-repeat-end ng-if="false"></tr>
            <tr ng-repeat-end ng-if="false"></tr>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmpropAllowedValues" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[["INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="prop_allowed_value_name" name="prop_allowed_value_name" placeholder="" value="@]]name]]"
                                           ng-model="propAllowedValue.language[0].pivot.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmpropAllowedValues.contact_number.$invalid && frmpropAllowedValues.prop_allowed_value_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">[["INPUT_PROPERTY" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="propAllowedValue.property_id" ng-options="item.language[0].pivot.property_id as item.language[0].pivot.name for item in properties">
                                        <option value=""></option>
                                    </select>

                                    {{--<select ng-model="propAllowedValue.property" ng-if="properties.length != 0">
                                        <option ng-repeat="property in properties" value="[[ property.id ]]"> [[ property.language[0].pivot.name ]]</option>
                                    </select>

                                    <select name="propAllowedValue.property" ng-if="properties.length == 0">
                                        <option value="[[ propAllowedValue.property_id ]]"> [[ propAllowedValue.property_id ]]</option>
                                    </select>--}}

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[["INPUT_STATE" | translate]]:</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="prop_allowed_value_state" value="active" ng-model="propAllowedValue.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="prop_allowed_value_state" value="inactive" ng-model="propAllowedValue.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmpropAllowedValues.position.$invalid && frmpropAllowedValues.position.$touched">State field is required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmpropAllowedValues.$invalid">[["BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propallowedvalue.js') ?>"></script>
@stop
