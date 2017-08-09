@extends('layouts.default')
@section('content')
    <div ng-controller="CausalLinksController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getCausalLinks()">
            <thead>
            <form ng-submit="filter()">
                <tr>
                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="Type your search keyword.."></th>
                    <th><input type="text" ng-model="search_causing_t" class="form-control" placeholder="Type your search keyword.."></th>
                    <th>
                        <select class="form-control" ng-model="search_t_state" ng-change="filter();" ng-options="item.id as item.language[0].pivot.name for item in tstates">
                            <option value=""></option>
                        </select>
                    </th>
                    <th><input type="text" ng-model="search_caused_t" class="form-control" placeholder="Type your search keyword.."></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><input type="submit" /></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('tp1_causing_t',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('t_state_name',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('tp2_caused_t',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER5" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.min',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER6" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.max',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER7" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.created_at',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER8" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.updated_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER9" | translate]] <button class="btn btn-default btn-xs btn-detail" ng-click="sort('causal_link.deleted_at',9)"><i ng-if="num == 9" class="[[type_class]]"></i><i ng-if="num != 9" class="fa fa-fw fa-sort"></i></button></th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">[[ "THEADER10" | translate]]</button></th>
            </tr>

            {{--<tr>
                <th>ID</th>
                <th>ID Causing_T</th>
                <th>Causing_T</th>
                <th>ID T_State</th>
                <th>T_State</th>
                <th>ID Caused_T</th>
                <th>Caused_T</th>
                <th>Min</th>
                <th>Max</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Deleted_at</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Causal Link</button></th>
            </tr>--}}
            </thead>
            <tbody>
            <tr ng-repeat="causallink in causallinks">
                <td>[[ causallink.id ]]</td>

                <td ng-show="[[causallinks[$index - 1].causing_t != causallinks[$index].causing_t]]">[[ causallinks[$index].tp1_causing_t ]]</td>
                <td ng-show="[[causallinks[$index - 1].causing_t == causallinks[$index].causing_t]]"></td>

                <td ng-show="[[causallinks[$index - 1].t_state_id != causallinks[$index].t_state_id && causallinks[$index - 1].causing_t != causallinks[$index].causing_t]]">[[ causallinks[$index].t_state_name ]]</td>
                <td ng-show="[[causallinks[$index - 1].t_state_id != causallinks[$index].t_state_id && causallinks[$index - 1].causing_t == causallinks[$index].causing_t]]">[[ causallinks[$index].t_state_name ]]</td>
                <td ng-show="[[causallinks[$index - 1].t_state_id == causallinks[$index].t_state_id && causallinks[$index - 1].causing_t == causallinks[$index].causing_t]]"></td>
                <td ng-show="[[causallinks[$index - 1].t_state_id == causallinks[$index].t_state_id && causallinks[$index - 1].causing_t != causallinks[$index].causing_t]]">[[ causallinks[$index].t_state_name ]]</td>


                <td>[[ causallink.tp2_caused_t ]]</td>
                <td>[[ causallink.min ]]</td>
                <td>[[ causallink.max ]]</td>
                <td>[[ causallink.created_at ]]</td>
                <td>[[ causallink.updated_at ]]</td>
                <td>[[ causallink.deteled_at ]]</td>

                {{--<td>[[ causallink.id ]]</td>
                <td>[[ causallink.causing_t ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ causallink.causing_transaction.language[0].pivot.t_name ]]</td>
                <td>[[ causallink.t_state_id ]]</td>
                <td>[[ causallink.t_state.language[0].pivot.name ]]</td>
                <td>[[ causallink.caused_t ]]</td>
                <td>[[ causallink.caused_transaction.language[0].pivot.t_name ]]</td>
                <td>[[ causallink.min ]]</td>
                <td>[[ causallink.max ]]</td>
                <td>[[ causallink.created_at ]]</td>
                <td>[[ causallink.updated_at ]]</td>
                <td>[[ causallink.deteled_at ]]</td>--}}
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', causallink.id)">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(causallink.id)">[[ "BTNTABLE3" | translate]]</button>
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
                        <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputCausingTransaction" class="col-sm-3 control-label">[[ "INPUT_CAUSING_TRANSACTION" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="causallink.causing_t" ng-options="item.id as item.language[0].pivot.t_name for item in transactionstype">
                                        <option value="">[[ "INPUT_causing_transaction_id" | translate]]</option>
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
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_STATE" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="causallink.t_state_id" ng-options="item.id as item.language[0].pivot.name for item in tstates">
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
                                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_CAUSED_TRANSACTION" | translate]]</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="causallink.caused_t" ng-options="item.id as item.language[0].pivot.t_name for item in transactionstype">
                                        <option value="">[[ "INPUT_caused_transaction_id" | translate]]</option>
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
                                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_MIN" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="causallink.min">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_MAX" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="causallink.max">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                </div>
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
    <script src="<?= asset('app/controllers/CausalLinks.js') ?>"></script>
@stop