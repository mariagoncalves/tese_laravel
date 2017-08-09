@extends('layouts.default')
@section('content')
    <h2>Waiting Links</h2>
    <div ng-controller="WaitingLinksController">
        <div growl></div>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getWaitingLinks()">
            <thead>
            <tr>
                <th>ID</th>
                <th>ID WaitedT</th>
                <th>WaitedT</th>
                <th>ID WaitedT Fact</th>
                <th>WaitedT Fact</th>
                <th>ID WaitingT Fact</th>
                <th>WaitingT Fact</th>
                <th>ID WaitingT</th>
                <th>WaitingT</th>
                <th>Min</th>
                <th>Max</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Deleted_at</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Waiting Link</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="waitinglink in waitinglinks">
                <td>[[ waitinglink.id ]]</td>
                <td>[[ waitinglink.waited_t.id ]]</td>
                <td>[[ waitinglink.waited_t.language[0].pivot.t_name ]]</td>
                <td>[[ waitinglink.waited_fact.id ]]</td>
                <td>[[ waitinglink.waited_fact.language[0].pivot.name ]]</td>
                <td>[[ waitinglink.waiting_fact.id ]]</td>
                <td>[[ waitinglink.waiting_fact.language[0].pivot.name ]]</td>
                <td>[[ waitinglink.waiting_transaction.id ]]</td>
                <td>[[ waitinglink.waiting_transaction.language[0].pivot.t_name ]]</td>
                <td>[[ waitinglink.min ]]</td>
                <td>[[ waitinglink.max ]]</td>
                <td>[[ waitinglink.created_at ]]</td>
                <td>[[ waitinglink.updated_at ]]</td>
                <td>[[ waitinglink.deteled_at ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', waitinglink.id)">Editar</button>
                    <button class="btn btn-info btn-xs btn-delete">Histórico</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(waitinglink.id)">Apagar</button>
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
                        <h4 class="modal-title" id="myModalLabel">[[form_title]]</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">Waited Transaction:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="waitinglink.waited_t.id" ng-options="item.id as item.language[0].pivot.t_name for item in transactionstype">
                                        <option value="">Selecionar a Transacção</option>
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
                                <label for="Gender" class="col-sm-3 control-label">Waited Fact:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="waitinglink.waited_fact.id" ng-options="item.id as item.language[0].pivot.name for item in tstates">
                                        <option value="">Selecionar o estado</option>
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
                                <label for="Gender" class="col-sm-3 control-label">Waiting Fact:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="waitinglink.waiting_fact.id" ng-options="item.id as item.language[0].pivot.name for item in tstates">
                                        <option value="">Selecionar o estado</option>
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
                                <label for="Gender" class="col-sm-3 control-label">Waiting Transaction:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="waitinglink.waiting_transaction.id" ng-options="item.id as item.language[0].pivot.t_name for item in transactionstype">
                                        <option value="">Selecionar a Transacção</option>
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
                                <label for="inputName" class="col-sm-3 control-label">Min</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="waitinglink.min">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Max</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                                           ng-model="waitinglink.max">
                                    <span class="help-inline"
                                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">Name field is required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/WaitingLinks.js') ?>"></script>
@stop