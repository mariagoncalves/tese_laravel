@extends('layouts.default')
@section('content')
    <div ng-controller="processTypesController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>
        <!--<table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>State</th>
                <th>Language</th>
                <th>Name</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Deleted_at</th>
            </tr>
            </thead>
            <tbody ng-repeat="processtype in processtypes">
                <tr ng-repeat="lang in processtype.language">
                    <td rowspan="[[processtype.language.length]]" ng-hide="$index>0">
                        [[processtype.id]]
                    </td>
                    <td rowspan="[[processtype.language.length]]" ng-hide="$index>0">
                        [[processtype.state]]
                    </td>
                    <td>[[lang.slug]]</td>
                    <td>[[lang.pivot.name]]</td>
                    <td>[[lang.pivot.created_at]]</td>
                    <td>[[lang.pivot.updated_at]]</td>
                    <td>[[lang.pivot.deleted_at]]</td>
                </tr>
            </tbody>
        </table>-->
        <br>
        <!-- Table-to-load-the-data Part  -->
        <table class="table" ng-init="getProcsTypes()">
            <thead>
            <form ng-submit="filter()">
            <tr>
                <th><input type="text" ng-model="search_id" class="form-control" placeholder="Type your search keyword.."></th>
                <th><input type="text" ng-model="search_name" class="form-control" placeholder="Type your search keyword.."></th>
                <th>
                    <select class="form-control" ng-change="filter();" ng-model="search_state">
                        <option value=""></option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th><input type="submit" /></th>
            </tr>
            </form>
            <tr>
                <th>[["THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[["THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type_name.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[["THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type.state',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[["THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type.created_at',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[["THEADER5" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type.updated_at',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th>[["THEADER6" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type.deleted_at',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[["THEADER7" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="processtype in processtypes">
                {{--<td>[[  processtype.id ]]</td>
                <td>[[ processtype.language[0].pivot.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ processtype.state ]]</td>
                <td>[[ processtype.created_at ]]</td>
                <td>[[ processtype.language[0].pivot.updated_at ]]</td>
                <td>[[ processtype.deleted_at ]]</td>--}}
                <td>[[  processtype.id ]]</td>
                <td>[[ processtype.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ processtype.state ]]</td>
                <td>[[ processtype.created_at ]]</td>
                <td>[[ processtype.updated_at ]]</td>
                <td>[[ processtype.deleted_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', processtype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-info btn-xs btn-hist">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(processtype.id)">[[ "BTNTABLE3" | translate]]</button>
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
                        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmProcessTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[["INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="process_type_name" name="process_type_name" placeholder="" value="[[name]]"
                                           ng-model="processtype.language[0].pivot.name" required>
                                    <div ng-messages="frmProcessTypes.process_type_name.$error" ng-show="frmProcessTypes.process_type_name.$invalid && frmProcessTypes.process_type_name.$touched">
                                        <p ng-message="required">[[ "REQUIRED_FIELD" | translate:translationData]]</p>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[["INPUT_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="process_type_state" value="active" ng-model="processtype.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="process_type_state" value="inactive" ng-model="processtype.state" required>Inactive
                                    </label>
                                    <div ng-messages="frmProcessTypes.process_type_state.$error" ng-show="frmProcessTypes.process_type_state.$invalid && frmProcessTypes.process_type_state.$touched">
                                        <p ng-message="required">Providing a state is mandatory.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Language" class="col-sm-3 control-label">[["INPUT_LANGUAGE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="language_id" ng-model="processtype.language[0].id" ng-options="item.id as item.slug for item in langs" required>
                                        <option value="">[["INPUT_language_id" | translate]]</option>
                                    </select>
                                    <div ng-messages="frmProcessTypes.language_id.$error" ng-show="frmProcessTypes.language_id.$invalid && frmProcessTypes.language_id.$touched">
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
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" ng-disabled="frmProcessTypes.$invalid" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
<script src="<?= asset('app/controllers/processtypes.js') ?>"></script>
@stop