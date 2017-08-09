@extends('layouts.default')
@section('content')
    <div ng-controller="propUnitTypeController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>
        <!-- Table-to-load-the-data Part -->
        <table class="table table-striped" st-table="displayedCollection" ng-init="getPropUnitTypes()" st-safe-src="propUnitTypes">
            <thead>
            <tr>
                <th st-sort="language[0].pivot.prop_unit_type_id"> [["THEADER1" | translate]]</th>
                <th st-sort="language[0].pivot.name">[["THEADER2" | translate]]</th>
                <th st-sort="state">[["THEADER3" | translate]]</th>
                <th>[["THEADER4" | translate]]</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">[["THEADER7" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="unit_type in displayedCollection">
                <td>[[ unit_type.language[0].pivot.prop_unit_type_id ]]</td>
                <td>[[ unit_type.language[0].pivot.name ]]</td>
                <td>[[ unit_type.state ]]</td>
                <td>[[ unit_type.language[0].pivot.updated_at ]]</td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', unit_type.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div>
            <posts-pagination-unit></posts-pagination-unit>
        </div>
        <!-- End of Table-to-load-the-data Part -->
        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"> [[form_title | translate]] </h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmUnitTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[["INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="prop_unit_type_name" name="prop_unit_type_name" placeholder="" value="@]]name]]"
                                           ng-model="propUnitType.language[0].pivot.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[["INPUT_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="prop_unit_type_state" value="active" ng-model="propUnitType.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="prop_unit_type_state" value="inactive" ng-model="propUnitType.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.position.$invalid && frmUnitTypes.position.$touched">State field is required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propunittype.js') ?>"></script>
@stop