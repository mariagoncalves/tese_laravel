<div class="modal-content" id = "myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">RelType</h4>
    </div>
    <div class="modal-body">
        <form id="formRelation" name="formRel" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label class="col-sm-3 control-label">[[ "THEADER2" | translate]]:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="relation_name" name="relation_name" ng-value="relation.language[0].pivot.name">
                    <ul ng-repeat="error in errors.relation_name" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getEntities()">
                <label class="col-sm-3 control-label">[[ "THEADER3" | translate]] 1:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="entity_type1">
                        <option value=""></option>
                        <option ng-repeat="entity in entities" ng-value="entity.language[0].pivot.ent_type_id" ng-selected="entity.language[0].pivot.ent_type_id == relation.ent_type1_id">[[ entity.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.entity_type1" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">[[ "THEADER3" | translate]] 2:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="entity_type2">
                        <option value=""></option>
                        <option ng-repeat="entity in entities" ng-value="entity.language[0].pivot.ent_type_id" ng-selected="entity.language[0].pivot.ent_type_id == relation.ent_type2_id">[[ entity.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.entity_type2" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group" ng-init="getTransactionsTypes()">
                <label class="col-sm-3 control-label">[[ "THEADER4" | translate]]:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="transactionsType">
                        <option value=""></option>
                        <option ng-repeat="transactionType in transactionTypes" ng-value="transactionType.language[0].pivot.transaction_type_id" ng-selected="transactionType.language[0].pivot.transaction_type_id == relation.transaction_type_id">[[ transactionType.language[0].pivot.t_name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.transactionsType" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group" ng-init="getTransactionsStates()">
                <label class="col-sm-3 control-label">[[ "THEADER5" | translate]]:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="transactionsState">
                        <option value=""></option>
                        <option ng-repeat="transactionState in transactionStates" ng-value="transactionState.language[0].pivot.t_state_id" ng-selected="transactionState.language[0].pivot.t_state_id == relation.t_state_id">[[ transactionState.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.transactionsState" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group" ng-init="getStates()">
                <label for="Gender" class="col-sm-3 control-label">[[ "THEADER6" | translate]]:</label>
                <div class="col-sm-9">
                    <label class="radio-inline state" ng-repeat="state in states">
                        <input type="radio" name="relation_state" value="[[ state ]]" ng-checked="state == relation.state">[[ state ]]
                    </label>
                    <ul ng-repeat="error in errors.relation_state" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>
    </div>
</div> 
