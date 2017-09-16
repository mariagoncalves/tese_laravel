<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
    </div>
    <div class="modal-body">
        <form id="formProperty" name="frmProp" class="form-horizontal" novalidate="">
            <div class="form-group">
                <label class="col-sm-3 control-label">[[ "THEADER1" | translate]]:</label>
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
                <label for="property_name" class="col-sm-3 control-label">[[ "THEADER3" | translate]]:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_name" name="property_name" ng-value="property.language[0].pivot.name" >
                    <ul ng-repeat="error in errors.property_name" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getStates()">
                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER10" | translate]]:</label>
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
                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER4" | translate]]:</label>
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
                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER6" | translate]]:</label>
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
                <label for="unitType" class="col-sm-3 control-label">[[ "THEADER7" | translate]]:</label>
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
                <label for="inputfieldSize" class="col-sm-3 control-label">[[ "THEADER8" | translate]]:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_fieldSize" name="property_fieldSize"  ng-value="property.form_field_size">
                    <ul ng-repeat="error in errors.property_fieldSize" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER9" | translate]]:</label>
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
                <label for="reference_entity" class="col-sm-3 control-label">[[ "INPUT_REF_ENT" | translate]]:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="reference_entity">
                        <option value=""></option>
                        <option ng-repeat="entity in entities" ng-value="entity.id" ng-selected="entity.id == property.fk_ent_type_id">[[ entity.language[0].pivot.name ]]</option>
                    </select>
                    <!-- <input type = "text" class="form-control" name = "reference_entity" id = "reference_entity"> -->
                    <ul ng-repeat="error in errors.reference_entity" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="assoc_properties" class="col-sm-3 control-label">Propriedades:</label>
                <div class="col-sm-9">
                    <script type="text/javascript">
                        $(".propselecting").select2({
                            placeholder: "Props",
                            allowClear: true
                        });
                    </script>
                    <select class="propselecting" style="width: 100%" multiple="multiple" id="propselect" name="propselect" ng-model="selroles" ng-options="role.id as role.name for role in roles" required>
                    </select>

                    <ul ng-repeat="error in errors.assoc_properties" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div> -->
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmProp.$invalid">[[ "BTN1FORM" | translate]]</button>
    </div>
</div>