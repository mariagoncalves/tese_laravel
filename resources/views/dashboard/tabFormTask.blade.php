
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">[[modal_formTab.propsform[0].ent_type.language[0].pivot.name]]</h3>
                                    </div>
                                    <div class="panel-body">
                                <form name="frmTaskForm" class="form-horizontal" novalidate="">
                                    <div ng-repeat="prop in modal_formTab.propsform" ng-switch="prop.value_type" emit-last-repeater-element>
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


                                    <div ng-repeat="prop in modal_formTab.propsformChild" ng-switch="prop.value_type">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">[[modal_formTab.propsformChild[0].ent_type.language[0].pivot.name]]</h3>
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