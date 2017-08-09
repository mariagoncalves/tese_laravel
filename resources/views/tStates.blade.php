@extends('layouts.default')
@section('content')
    <div ng-controller="tStatesController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <!-- Table-to-load-the-data Part  -->
        <table class="table" ng-init="getTStates()">
            <thead>
            <form ng-submit="filter()">
                <tr>
                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder="Type your search keyword.."></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><input type="submit" /></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.created_at',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.updated_at',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER5" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.deleted_at',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[[ "THEADER6" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="tstate in tstates">
                <td>[[ tstate.id ]]</td>
                <td>[[ tstate.t_state_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ tstate.t_state_name_created_at ]]</td>
                <td>[[ tstate.t_state_name_updated_at ]]</td>
                <td>[[ tstate.t_state_name_deleted_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', tstate.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(tstate.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>
        <!-- End of Table-to-load-the-data Part -->
        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">[[ form_title | translate]]</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTStates" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="t_state_name" name="t_state_name" placeholder=""
                                           ng-model="tstate.language[0].pivot.name">
                                    <div ng-messages="frmTStates.t_state_name.$error" ng-show="frmTStates.t_state_name.$invalid && frmTStates.t_state_name.$touched">
                                        <p ng-message="required">Providing a name is mandatory.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="selectLanguage" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="t_state_language_id" ng-model="tstate.language[0].id" ng-options="item.id as item.slug for item in langs">
                                        <option value="">[[ "INPUT_language_id" | translate]]</option>
                                    </select>
                                    <div ng-messages="frmTStates.t_state_language_id.$error" ng-show="frmTStates.t_state_language_id.$invalid && frmTStates.t_state_language_id.$touched">
                                        <p ng-message="required">Providing a language is mandatory.</p>
                                    </div>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                        <li>[[ error[0] ]]</li>
                                </ul>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" ng-disabled="frmTStates.$invalid" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/tStates.js') ?>"></script>
@stop