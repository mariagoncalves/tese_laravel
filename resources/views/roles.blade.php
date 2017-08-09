@extends('layouts.default')
@section('content')

    <h2>Roles</h2>
    <div ng-controller="rolesController">
        <div growl></div>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getRoles()">


            <thead>
            <form ng-submit="filter()">
                <tr>

                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="ID"></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder="Name"></th>
                    <th><input type="text" ng-model="search_updated_at" class="form-control" placeholder="Updated At"></th>
                    <th><input type="submit" /></th>
                    <th></th>
                    <th></th>
                </tr>
            </form>
            <tr>
                <th>ID<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>Name<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role_name.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>Updated at<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role.updated_at',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>Actors</th>
                <th>Users</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">Add New Role</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="role in roles">

                <td>[[ role.id ]]</td>
                <td>[[ role.name]]</td>
                <td>[[ role.updated_at]]</td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_actors', role.id)">Assign Actors</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_actors', role.id)">View Actors List</button>
                </td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_users', role.id)">Assign Users</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_users', role.id)">View Users List</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', role.id)">Edit</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', role.id)">Remove</button>
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

                            <div ng-switch-when="add_actors">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">Assigning Actors to [[ role.name]]</label>
                                        <div class="col-sm-12">
                                            <label>Actors List</label>
                                            <script type="text/javascript">
                                                $(".actorselecting").select2({
                                                    placeholder: "Actor Roles",
                                                    allowClear: true
                                                });
                                            </script>
                                            <select class="actorselecting" style="width: 100%" multiple="multiple" id="actorselect" name="actorselect" ng-model="selactors" ng-options="actor.id as actor.name for actor in actors" required>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="add_users">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">Assigning Users to [[ role.name]]</label>
                                        <div class="col-sm-12">
                                            <label>Users List</label>
                                            <script type="text/javascript">
                                                $(".userselecting").select2({
                                                    placeholder: "Users Roles",
                                                    allowClear: true
                                                });
                                            </script>
                                            <select class="userselecting" style="width: 100%" multiple="multiple" id="userselect" name="userselect" ng-model="selusers" ng-options="user.id as user.name for user in users" required>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_actors">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ role.name]]</label>
                                        <label class="col-sm-3 control-label">Active Actors List</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selactors">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Updated at</th>
                                                    <th>Remove Actor</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_actors', role.id)">Assign Actors</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="selactor in selactors">
                                                    <td>[[ selactor.id ]]</td>
                                                    <td>[[ selactor.name ]]</td>
                                                    <td>[[ selactor.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeactor(role.id,selactor.id)" ng-disabled="frmUnitTypes.$invalid">Remove Actor</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_users">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ role.name]]</label>
                                        <label class="col-sm-3 control-label">Active Users List</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selusers">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Updated at</th>
                                                    <th>Remove User</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_users', role.id)">Assign Users</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="seluser in selusers">
                                                    <td>[[ seluser.id ]]</td>
                                                    <td>[[ seluser.name ]]</td>
                                                    <td>[[ seluser.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeuser(role.id,seluser.id)" ng-disabled="frmUnitTypes.$invalid">Remove User</button>
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
                                        <label for="inputName" class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="" value="@]]name]]"
                                                   ng-model="role.name" ng-required="true">
                                            <span class="help-inline"
                                                  ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">Name field is required</span>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                    <div ng-switch on="modalstate">
                        <div ng-switch-when="view_actors">
                        </div>
                        <div ng-switch-when="view_users">
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
    <script src="<?= asset('app/controllers/roles.js') ?>"></script>
@stop