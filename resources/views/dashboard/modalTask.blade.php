
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                    </div>
                    <div class="modal-body">
                        <uib-tabset active="activeTabIndex" type="tabs">
                            <uib-tab ng-repeat="tab in tabs" index="$index" heading="[[tab.title]]">
                                <br>
                                <div class="text-center" ng-show="modal.formTab.loading"><img src="<?= asset('../91.gif') ?>" /></div>
                                <div ng-include="tab.templateUrl"></div>
                            </uib-tab>
                        </uib-tabset>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        {{--<button type="button" class="btn btn-lg btn-light-green" id="btn-save" ng-click="save(modalstate, id)" >[[ "BTN1FORM" | translate]]</button>--}}
                    </div>
                </div>