<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[ "FORM_DRAG_DROP" | translate]]</h4>
    </div>

    <div class="modal-body">
        <h4>[[ "Page_Name" | translate]]</h4>
        <ul ui-sortable="sortableOptionsEnt" ng-model="propsEnt" class="list-group">
            <li ng-repeat="prop in propsEnt" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
        </ul>

       <pre>[[propsEnt]]</pre>
    </div>
</div>