@extends('layouts.default')
@section('content')

    <h2>[[ "PHEADER" | translate]]</h2>
    <div ng-controller="actorsController">
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">[[ "BTN1" | translate]]</button>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getActors()">
            <thead>
            <form ng-submit="filter()">
            <tr>

                <th><input type="text" ng-model="search_id" class="form-control" placeholder='[[ "THEADER1" | translate]]'></th>
                <th><input type="text" ng-model="search_name" class="form-control" placeholder='[[ "THEADER2" | translate]]'></th>
                <th><input type="text" ng-model="search_updated_at" class="form-control" placeholder='[[ "THEADER3" | translate]]'></th>
               <th><input type="submit" value='[[ "BTN8" | translate]]' /></th>
            </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('actor.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('actor_name.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('actor.updated_at',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]]</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">[[ "BTN2" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="actor in actors">

                <td>[[ actor.id ]]</td>
                <td>[[ actor.name]]</td>
                <td>[[ actor.updated_at]]</td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', actor.id)">[[ "BTN3" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_roles', actor.id)">[[ "BTN4" | translate]]</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', actor.id)">[[ "BTN5" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', actor.id)">[[ "BTN6" | translate]]</button>
                    {{--<button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', actor.id)">[[ "BTN7" | translate]]</button>--}}
                    {{--<button class="btn btn-primary btn-xs btn-delete">History</button>--}}
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
                        <div ng-switch on="modalstate">



                            <div ng-switch-when="add_roles">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL1" | translate]][[ actor.name]]</label>
                                        <div class="col-sm-12">
                                            <label>[[ "LBL2" | translate]]</label>
                                            <script type="text/javascript">
                                                $(".roleselecting").select2({
                                                    placeholder: "Actor Roles",
                                                    allowClear: true
                                                });
                                            </script>
                                            <select class="roleselecting" style="width: 100%" multiple="multiple" id="roleselect" name="roleselect" ng-model="selroles" ng-options="role.id as role.name for role in roles" required>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_roles">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ actor.name]]</label>
                                        <label class="col-sm-12 control-label" style="text-align: left">[[ "LBL3" | translate]]</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selroles">
                                                <thead>
                                                <tr>
                                                    <th>[[ "T2HEADER1" | translate]]</th>
                                                    <th>[[ "T2HEADER2" | translate]]</th>
                                                    <th>[[ "T2HEADER3" | translate]]</th>
                                                    {{--<th>[[ "T2HEADER4" | translate]]</th>--}}
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', actor.id)">[[ "BTN9" | translate]]</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="selrole in selroles">
                                                    <td>[[ selrole.id ]]</td>
                                                    <td>[[ selrole.name ]]</td>
                                                    <td>[[ selrole.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removerole(actor.id,selrole.id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN10" | translate]]</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>


                                <div ng-switch-default>
                        <form name="frmUnitTypes" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "LBL4" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="actor_name" name="actor_name" placeholder="" value="@]]name]]"
                                           ng-model="actor.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">[[ "WRNG1" | translate]]</span>
                                </div>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                    <div ng-switch on="modalstate">
                        <div ng-switch-when="view_roles">
                        </div>
                        <div ng-switch-default>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[btn_label]]</button>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/actors.js') ?>"></script>

@stop

