<div class="modal-content" id = "myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.ADD_PROPERTIES')}}</h4>
    </div>
    <div class="modal-body">
        <form id = "formPropRel" name="formProps" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('properties/messages.THEADER13')}}:</label>
                <div class="col-sm-9" ng-init = "getRelations()">
                    <select class="form-control" name = "relation_type">
                        <option value=""></option>
                        <option ng-repeat="relation in relations" ng-value="relation.id" ng-selected="relation.id == property.rel_type_id" >[[ relation.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.relation_type" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group">
                <label for="property_name_rel" class="col-sm-3 control-label">{{trans('properties/messages.THEADER3')}}:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_name_rel" name="property_name_rel" ng-value="property.language[0].pivot.name" >
                    <ul ng-repeat="error in errors.property_name_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getStates()">
                <label for="Gender" class="col-sm-3 control-label">{{trans('properties/messages.THEADER10')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline state" ng-repeat="state in states">
                        <input type="radio" name="property_state_rel" value="[[ state ]]" ng-checked="state == property.state">[[ state ]]
                    </label>
                    <ul ng-repeat="error in errors.property_state_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getValueTypes()">
                <label for="Gender" class="col-sm-3 control-label">{{trans('properties/messages.THEADER4')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline valueType" ng-repeat="valueType in valueTypes">
                        <input type="radio" name="property_valueType_rel" value="[[ valueType ]]" ng-checked="valueType == property.value_type" required>[[ valueType ]]
                    </label>
                    <ul ng-repeat="error in errors.property_valueType_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getFieldTypes()">
                <label for="Gender" class="col-sm-3 control-label">{{trans('properties/messages.THEADER6')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline fieldType" ng-repeat="fieldType in fieldTypes">
                        <input type="radio" name="property_fieldType_rel" value="[[ fieldType ]]" ng-checked="fieldType == property.form_field_type" required>[[ fieldType ]]
                    </label>
                    <ul ng-repeat="error in errors.property_fieldType_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getUnits()">
                <label for="units" class="col-sm-3 control-label">{{trans('properties/messages.THEADER7')}}:</label>
                <div class="col-sm-9">
                    <select class="form-control" name = "units_name">
                        <option value="0"></option>
                        <option ng-repeat="unit in units" value="[[ unit.id ]]" ng-selected="unit.id == property.unit_type_id" >[[ unit.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.units_name" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

           <div class="form-group">
                <label for="inputfieldSize" class="col-sm-3 control-label">{{trans('properties/messages.THEADER8')}}:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_fieldSize_rel" name="property_fieldSize_rel" ng-value="property.form_field_size">
                    <ul ng-repeat="error in errors.property_fieldSize_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">{{trans('properties/messages.THEADER9')}}:</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline mandatory">
                        <input type="radio" name="property_mandatory_rel" ng-value="1" ng-checked="1 == property.mandatory" required>{{trans('properties/messages.YES')}}
                    </label>
                    <label for="" class="radio-inline mandatory">
                        <input type="radio" name="property_mandatory_rel" ng-value="0" ng-checked="0 == property.mandatory" required>{{trans('properties/messages.NO')}}
                    </label>
                    <ul ng-repeat="error in errors.property_mandatory_rel" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="saveRel(modalstate, id)">{{trans('properties/messages.BTN1FORM')}}</button>
    </div>
</div>