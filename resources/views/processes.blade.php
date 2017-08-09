@extends('layouts.default')
@section('content')
    <h2>Tipos de Processos</h2>
    <div ng-controller="processesController">
        <div growl></div>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getProcs()">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>State</th>
                <th>Process Type</th>
                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Adicionar Novo Processo</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="process in processes">
                <td>[[  process.id ]]</td>
                <td>[[ process.language[0].pivot.name ]]</td> <!--processtype.pivot.name quando é feito da linguagem para o processtype-->
                <td>[[ process.state ]]</td>
                <td>[[ process.process_type.language[0].pivot.name ]]</td>
                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', process.id)">Editar</button>
                    <button class="btn btn-danger btn-xs btn-delete">Histórico</button>
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
                        <form name="frmProcesses" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="process_name" name="process_name" placeholder="" value="[[name]]"
                                           ng-model="process.language[0].pivot.name">
                                    <span class="help-inline"
                                          ng-show="frmProcesses.process_name.$invalid && frmProcesses.process_name.$touched">Name field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">Process Type:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="process.process_type_id" ng-options="item.id as item.language[0].pivot.name for item in processtypes">
                                        <option value="">Selecionar Tipo de Processo</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmProcesses.language_id.$invalid && frmProcesses.language_id.$touched">State field is required</span>
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
                                          ng-show="frmProcesses.process_state.$invalid && frmProcesses.process_state.$touched">State field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">Language:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" ng-model="process.language[0].id" ng-options="item.id as item.slug for item in langs">
                                        <option value="">Selecionar Idioma</option>
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmProcesses.language_id.$invalid && frmProcesses.language_id.$touched">State field is required</span>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                        <li>[[ error[0] ]]</li>
                                </ul>

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
    <script src="<?= asset('app/controllers/processes.js') ?>"></script>
@stop