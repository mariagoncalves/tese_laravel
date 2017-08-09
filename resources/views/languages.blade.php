@extends('layouts.default')
@section('content')

    <h2>Tipos de Transacções</h2>
    <div ng-controller="languagesController">
        <div growl></div>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getLanguages()">


            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>State</th>

                <th>Updated</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">Add New Language</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="language in languages">

                <td>[[ language.id ]]</td>
                <td>[[ language.name]]</td>
                <td>[[ language.slug]]</td>
                <td>[[ language.state]]</td>
                <td>[[ language.updated_on]]</td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', language.id)">Edit</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', language.id)">Remove</button>
                    <button class="btn btn-primary btn-xs btn-delete">History</button>
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
                        <form name="frmUnitTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="language_name" name="language_name" placeholder="" value="@]]name]]"
                                           ng-model="language.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">Name field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSlug" class="col-sm-3 control-label">Slug</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="language_slug" name="language_slug" placeholder="" value="@]]slug]]"
                                           ng-model="language.slug" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">Slug field is required</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Gender" class="col-sm-3 control-label">State:</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="language_state" value="active" ng-model="language.state" required>Active
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="language_state" value="inactive" ng-model="language.state" required>Inactive
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.position.$invalid && frmUnitTypes.position.$touched">State field is required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[btn_label]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/languages.js') ?>"></script>
@stop