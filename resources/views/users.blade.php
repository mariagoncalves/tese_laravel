@extends('layouts.default')
@section('content')
    <h2>Users</h2>
    <div ng-controller="usersController">
        <div growl></div>

        <table class="table" ng-init="getUsers()">
            <thead>
            <form ng-submit="filter()">
                <tr>

                    <th><input type="text" ng-model="search_id" class="form-control" placeholder="ID"></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder="Name"></th>
                    <th><input type="text" ng-model="search_email" class="form-control" placeholder="Email"></th>
                    <th><input type="text" ng-model="search_user_name" class="form-control" placeholder="User Name"></th>
                    <th><input type="text" ng-model="search_languageslug" class="form-control" placeholder="Language"></th>
                    <th><input type="text" ng-model="search_user_type" class="form-control" placeholder="User Type"></th>
                    <th><input type="text" ng-model="search_entity" class="form-control" placeholder="Entity"></th>
                    <th><input type="text" ng-model="search_updated_at" class="form-control" placeholder="Updated At"></th>
                    <th><input type="submit" /></th>
                </tr>
            </form>
            <tr>
                <th>ID <button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>Name<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>Email<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.email',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>User Name<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.user_name',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>Language<button class="btn btn-default btn-xs btn-detail" ng-click="sort('languageslug',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th>User Type<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.user_type',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>Entity<button class="btn btn-default btn-xs btn-detail" ng-click="sort('selentity',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>Updated<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.updated_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>Roles</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">Add New User</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="user in users">

                <td>[[ user.id ]]</td>
                <td>[[ user.name]]</td>
                <td>[[ user.email]]</td>
                <td>[[ user.user_name]]</td>
                <td>[[ user.languageslug]]</td>
                <td>[[ user.user_type]]</td>
                <td>[[ user.selentity]]</td>
                <td>[[ user.updated_at]]</td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', user.id)">Assign Roles</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_roles', user.id)">View Roles List</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', user.id)">Edit</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', user.id)">Remove</button>
                    {{--<button class="btn btn-primary btn-xs btn-delete">History</button>--}}
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>


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
                                        <label class="col-sm-12 control-label" style="text-align: center">Assigning Roles to [[ user.name]]</label>
                                        <div class="col-sm-12">
                                            <label>Roles List</label>
                                            <script type="text/javascript">
                                                $(".roleselecting").select2({
                                                    placeholder: "User Roles",
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
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ user.name]]</label>
                                        <label class="col-sm-3 control-label">Active Roles List</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selroles">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Updated at</th>
                                                    <th>Remove Role</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', user.id)">Assign Roles</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="selrole in selroles">
                                                    <td>[[ selrole.id ]]</td>
                                                    <td>[[ selrole.name ]]</td>
                                                    <td>[[ selrole.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removerole(user.id,selrole.id)" ng-disabled="frmUnitTypes.$invalid">Remove Role</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div ng-switch-default>


                        <form name="frmUsers" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="" value="@]]name]]"
                                           ng-model="user.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">Name field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">User Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user_user_name" name="user_user_name" placeholder="" value="@]]user_name]]"
                                           ng-model="user.user_name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">User Name field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="" value="@]]email]]"
                                           ng-model="user.email" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">Email field is required</span>
                                </div>
                            </div>


                            <div ng-switch on="modalstate">
                                <div ng-switch-when="add">

                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password' class="form-control" type="password" name='user_password' placeholder='' required>
                                            <span class="help-inline" ng-show="form.password.$error.required">
                                        Field required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">Confirm Password</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password_verify' class="form-control" type="password" name='confirm_password' placeholder='' required data-password-verify="user.password">
                                            <span class="help-inline" ng-show="form.password.$error.required">
                                        Field required</span>
                                            <span class="help-inline" ng-show="frmUsers.confirm_password.$error.passwordVerify">
                                    Fields are not equal!</span>
                                        </div>

                                    </div>

                                </div>
                                <div ng-switch-when="edit">

                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">New Password</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password' class="form-control" type="password" name='user_password' placeholder=''>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">Confirm New Password</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password_verify' class="form-control" type="password" name='confirm_password' placeholder='' ng-required='user.password' data-password-verify="user.password">
                                            <span class="help-inline" ng-show="frmUsers.confirm_password.$error.passwordVerify">
                                    Fields are not equal!</span>
                                        </div>

                                    </div>

                                </div>
                                {{--<div  ng-switch-when="remove"></div>--}}
                                {{--<div class="animate-switch" ng-switch-default>default</div>--}}
                            </div>


                            <div class="form-group">
                                <label for="langSelect" class="col-sm-3 control-label">Language</label>
                                {{--<div class="col-sm-9">--}}
                                {{--<select ng-model="user.language_id" ng-options="lang.id as lang.name for lang in langs" ng-init="lang = [[user.language_id]]"></select>--}}
                                {{--</div>--}}
                                <div class="col-sm-9">
                                    <select class="form-control" name="languageselect" ng-model="user.language_id" ng-options="lang.id as lang.name for lang in langs" required>
                                        <option value="">Select a Language</option>
                                    </select>
                                    <div ng-messages="frmUsers.languageselect.$error" ng-show="frmUsers.languageselect.$invalid && frmUsers.languageselect.$touched">
                                        <p ng-message="required">Selecting a Language is mandatory.</p>
                                    </div>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>
                            </div>


                            <div class="form-group">
                                <label for="inputUsertype" class="col-sm-3 control-label">User Type:</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="user_type" value="internal" ng-model="user.user_type" required>Internal
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="user_type" value="external" ng-model="user.user_type" required>External
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmUsers.position.$invalid && frmUsers.position.$touched">User Type field is required</span>
                                </div>
                            </div>

                            <div ng-switch on="user.user_type">
                                <div ng-switch-when="external">
                                    <div class="form-group">
                                        <label for="entitiesSelect" class="col-sm-3 control-label">Entity</label>
                                        <div class="col-sm-9">
                                            {{--<select ng-model="user.entity_id" ng-options="entity.id as entity.name for entity in entities" ng-init="entity = [[user.entity_id]]"></select>--}}
                                            {{--</div>--}}

                                            <select class="form-control" name="entityselect" ng-model="user.entity_id" ng-options="entity.id as entity.name for entity in entities" required>
                                                <option value="">Select an Entity</option>
                                            </select>
                                            <div ng-messages="frmUsers.entityselect.$error" ng-show="frmUsers.entityselect.$invalid && frmUsers.entityselect.$touched">
                                                <p ng-message="required">Providing a process type is mandatory.</p>
                                            </div>
                                        </div>
                                        <br>
                                        <ul ng-repeat="error in errors">
                                            <li>[[ error[0] ]]</li>
                                        </ul>

                                    </div>
                                </div>

                            </div>
                        </form>
                            </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[btn_label]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/users.js') ?>"></script>

@stop