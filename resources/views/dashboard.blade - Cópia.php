@extends('layouts.default')
@section('content')
    <div ng-controller="dashboardController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>
        <br>
        <br>
        <button type="button" class="btn btn-lg btn-success" ng-click="togglemyModalNewProcess('add', 0)">Add New Process</button>
        <button type="button" class="btn btn-lg btn-success" ng-click="togglemyModalNewTask('add', 0)">Add New Task</button>
        <br>
        <button type="button" class="btn btn-default" ng-click="open('lg')">Large modal</button>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        <span class="badge">just now</span>
                        <i class="fa fa-fw fa-calendar"></i> Calendar updated
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">4 minutes ago</span>
                        <i class="fa fa-fw fa-comment"></i> Commented on a post
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">23 minutes ago</span>
                        <i class="fa fa-fw fa-truck"></i> Order 392 shipped
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">46 minutes ago</span>
                        <i class="fa fa-fw fa-money"></i> Invoice 653 has been paid
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">1 hour ago</span>
                        <i class="fa fa-fw fa-user"></i> A new user has been added
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">2 hours ago</span>
                        <i class="fa fa-fw fa-check"></i> Completed task: "pick up dry cleaning"
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">yesterday</span>
                        <i class="fa fa-fw fa-globe"></i> Saved the world
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge">two days ago</span>
                        <i class="fa fa-fw fa-check"></i> Completed task: "fix error on sales page"
                    </a>
                </div>
                <div class="text-right">
                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Table-to-load-the-data Part  -->
        <table class="table" ng-init="getEntityTypes()">
            <thead>
            <form ng-submit="filter()">
                <tr>
                    <th><input type="text" ng-model="search_process_type" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_result_type" class="form-control" placeholder="Type your search keyword.."></th>
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
                    <th><input type="text" ng-model="search_executer" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="submit" /></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('process_type_name.name',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('transaction_type_name.t_name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.id',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type_name.name',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER5" | translate]] </th>
                <th>[[ "THEADER6" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name.name',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER7" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.state',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER8" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.created_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER9" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.updated_at',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER10" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('ent_type.deleted_at',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[[ "THEADER11" | translate]]</button></th>
            </tr>
            {{--
                        <tr>
                            <th>Process Type</th>
                            <th>Transaction Type</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Entity Type</th>
                            <th>Transaction State</th>
                            <th>State</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Deleted_at</th>
                            <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Adicionar Novo Tipo de Transacção</button></th>
                        </tr>--}}
            </thead>
            <tbody>
            <tr ng-repeat="entitytype in entitytypes">
                {{--<td ng-show="[[entitytypes[$index - 1].transaction_type_id != entitytypes[$index].transaction_type_id]]">[[ entitytypes[$index].transactions_type.language[0].pivot.t_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id == entitytypes[$index].transaction_type_id]]"></td>

                <td>[[ entitytype.id ]]</td>
                <td>[[ entitytype.language[0].pivot.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ entitytype.ent_type.language[0].pivot.name ]]</td>
                <td>[[ entitytype.t_states.language[0].pivot.name ]]</td>
                <td>[[ entitytype.state ]]</td>
                <td>[[ entitytype.created_at ]]</td>
                <td>[[ entitytype.language[0].pivot.updated_at ]]</td>
                <td>[[ entitytype.deleted_at ]]</td>--}}

                <td ng-show="[[entitytypes[$index - 1].process_type_id != entitytypes[$index].process_type_id]]">[[ entitytypes[$index].process_type_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].process_type_id == entitytypes[$index].process_type_id]]"></td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id != entitytypes[$index].transaction_type_id]]">[[ entitytypes[$index].transaction_type_t_name ]]</td>
                <td ng-show="[[entitytypes[$index - 1].transaction_type_id == entitytypes[$index].transaction_type_id]]"></td>

                <td>[[ entitytype.id ]]</td>
                <td>[[ entitytype.ent_type_name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td></td>
                <td>[[ entitytype.t_state_name ]]</td>
                <td>[[ entitytype.state ]]</td>
                <td>[[ entitytype.created_at ]]</td>
                <td>[[ entitytype.updated_at ]]</td>
                <td>[[ entitytype.deleted_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', entitytype.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(entitytype.id)">[[ "BTNTABLE3" | translate]]</button>
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
                        <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_NAME" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="entitytype.language[0].pivot.name">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputTransactionType" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_TYPE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.transaction_type_id" ng-options="item.id as item.language[0].pivot.t_name for item in transactiontypes">
                                        <option value="">[[ "INPUT_transaction_type_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="inputEntType" class="col-sm-3 control-label">[[ "INPUT_ENTITY_TYPE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.ent_type_id" ng-options="item.id as item.language[0].pivot.name for item in enttypes">
                                        <option value="">[[ "INPUT_entity_type_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="transactiontype_state" value="active" ng-model="entitytype.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="transactiontype_state" value="inactive" ng-model="entitytype.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.process_state.$invalid && frmTransactionTypes.process_state.$touched">State field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.t_state_id" ng-options="item.language[0].pivot.t_state_id as item.language[0].pivot.name for item in tstates">
                                        <option value="">[[ "INPUT_transaction_state_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.slug for item in langs">
                                        <option value="">[[ "INPUT_language_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade bs-example-modal-lg" id="myModalNewTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                    </div>
                    <div class="modal-body">


                        <ul class="nav nav-pills">
                            <li class="active"><a href="#task" data-toggle="tab">Task</a></li>
                            <li ng-if="modal.formExist==true">
                                <a href="#tabForm" data-toggle="tab">Task Form</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="task">
                                <div class="spinner" ng-show="loading"></div>
                                <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_NAME" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                                   ng-model="modal.transaction.language[0].pivot.name">
                                            <span class="help-inline"
                                                  ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputTransactionType" class="col-sm-3 control-label">Transaction Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" ng-model="modal.transaction.transaction_type_id" ng-options="item.id as item.language[0].pivot.t_name for item in transactiontypes">
                                                <option value=""></option>
                                            </select>
                                            <span class="help-inline"
                                                  ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                        </div>
                                        <br>
                                        <ul ng-repeat="error in errors">
                                            <li>[[ error[0] ]]</li>
                                        </ul>

                                    </div>

                                    <div class="form-group">
                                        <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_STATE" | translate]]</label>
                                        <div class="col-sm-9">
                                            <label for="" class="radio-inline state">
                                                <input type="radio" name="transactiontype_state" value="active" ng-model="modal.transaction.state" required>Active
                                            </label>
                                            <label for="" class="radio-inline state">
                                                <input type="radio" name="transactiontype_state" value="inactive" ng-model="modal.transaction.state" required>Inactive
                                            </label>
                                            <span class="help-inline"
                                                  ng-show="frmTransactionTypes.process_state.$invalid && frmTransactionTypes.process_state.$touched">State field is required</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.slug for item in langs">
                                                <option value=""></option>
                                            </select>
                                            <span class="help-inline"
                                                  ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                        </div>
                                        <br>
                                        <ul ng-repeat="error in errors">
                                            <li>[[ error[0] ]]</li>
                                        </ul>

                                    </div>
                                </form>



                                <button type="button" class="btn btn-primary" ng-click="changeTabBoot(modal.transaction.transaction_type_id)">Next</button>
                            </div>
                            <div ng-if="modal.formExist==true" class="tab-pane" id="tabForm">
                                <br>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">[[modal.propsform[0].ent_type.language[0].pivot.name]]</h3>
                                    </div>
                                    <div class="panel-body">
                                <form name="frmTaskForm" class="form-horizontal" novalidate="">
                                    <div ng-repeat="prop in modal.propsform" ng-switch="prop.value_type" emit-last-repeater-element>
                                        <div class="form-group" ng-switch-when="text|double|int" ng-switch-when-separator="|">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="[[prop.language[0].form_field_name]]" name="[[prop.language[0].form_field_name]]" placeholder=""
                                                       ng-model="transaction.language[0].pivot.name">
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="bool">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="transactiontype_state" value="active" ng-model="transaction.state" required>Active
                                                </label>
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="transactiontype_state" value="inactive" ng-model="transaction.state" required>Inactive
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="enum" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="radio|checkbox" ng-switch-when-separator="|">
                                                <label for="" class="radio-inline state">
                                                    <input ng-repeat="p_a_v in prop.prop_allowed_values" type="[[prop.form_field_type]]" name="[[prop.language[0].form_field_name]]" value="[[p_a_v.id]]" ng-model="transaction.state" required>[[p_a_v.language[0].pivot_name]]
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="selectbox">
                                                <select class="form-control" ng-model="task.id" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values" ng-change="verParEntType(task.id)">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="ent_ref">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.language[0].pivot.name for item in prop.fk_ent_type.entity">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>
                                    </div>


                                    <div ng-repeat="prop in modal.propsformChild" ng-switch="prop.value_type">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">[[modal.propsformChild[0].ent_type.language[0].pivot.name]]</h3>
                                        </div>

                                        <div class="form-group" ng-switch-when="text|double|int" ng-switch-when-separator="|">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="[[prop.language[0].form_field_name]]" name="[[prop.language[0].form_field_name]]" placeholder=""
                                                       ng-model="transaction.language[0].pivot.name">
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="bool">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="transactiontype_state" value="active" ng-model="transaction.state" required>Active
                                                </label>
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="transactiontype_state" value="inactive" ng-model="transaction.state" required>Inactive
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="enum" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="radio|checkbox" ng-switch-when-separator="|">
                                                <label for="" class="radio-inline state">
                                                    <input ng-repeat="p_a_v in prop.prop_allowed_values" type="[[prop.form_field_type]]" name="[[prop.language[0].form_field_name]]" value="[[p_a_v.id]]" ng-model="transaction.state" required>[[p_a_v.language[0].pivot_name]]
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="selectbox">
                                                <select class="form-control" ng-model="entitytype.language[0].id" ng-change="verParEntType(item.id)" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="ent_ref">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.language[0].pivot.name for item in prop.fk_ent_type.entity">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="myModalNewProcess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Process</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmProcess" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="process_name" name="process_name" placeholder=""
                                           ng-model="process.language[0].pivot.name">
                                    <span class="help-inline"
                                          ng-show="frmProcess.process_name.$invalid && frmProcess.process_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputTransactionType" class="col-sm-3 control-label">Process Type:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="process_type_id" ng-model="process.process_type_id" ng-options="item.id as item.language[0].pivot.name for item in processtypes">
                                        <option value=""></option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmProcess.process_type_id.$invalid && frmProcess.process_type_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">State:</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="process_state" value="active" ng-model="process.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="process_state" value="inactive" ng-model="process.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmProcess.process_state.$invalid && frmProcess.process_state.$touched">State field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="process.language[0].id" ng-options="item.id as item.slug for item in langs">
                                        <option value="">[[ "INPUT_language_id" | translate]]</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dashboard.js') ?>"></script>
@stop