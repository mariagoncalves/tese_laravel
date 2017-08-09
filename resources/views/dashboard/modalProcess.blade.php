
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                        {{--<button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>--}}
                    </div>
                </div>
