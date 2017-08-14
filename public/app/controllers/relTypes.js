app.controller('RelationTypesManagmentControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {

    $scope.relations = [];
    $scope.entities = [];
    $scope.transactionTypes = [];
    $scope.transactionStates = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.errors = [];

    $translatePartialLoader.addPart('relTypes');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.getRelations = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }

        $http.get('/relTypes/get_relations?page='+pageNumber).then(function(response) {
            console.log(response);
            $scope.relations = response.data.data;

            $scope.totalPages = response.data.last_page;
            $scope.currentPage = response.data.current_page;

            // Pagination Range
            var pages = [];

            for (var i = 1; i <= response.data.last_page; i++) {
                pages.push(i);
            }

            $scope.range = pages;
        });
    };

    $scope.toggle = function(modalstate, id) {
        $('#formRelation')[0].reset();
        $scope.relation = null;
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                console.log(id);
                $http.get(API_URL + '/getRelationsTypes/' + id)
                    .then(function(response) {
                        $scope.relation = response.data;
                    });
                break;
            default:
                break;
        }
        $('#myModal').modal('show');
        $scope.errors = null;
    };

    /*$scope.save = function(modalstate, id) {
        var url      = API_URL + "Relation";


        console.log(jQuery('#formRelation').serializeArray());

        var formData = JSON.parse(JSON.stringify(jQuery('#formRelation').serializeArray()));

        console.log(formData);

        if (modalstate === 'edit') {
            url += "/" + id ;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param(formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            //First function handles success
            $scope.errors = [];
            $scope.getRelations();
            //$('#myModal').modal('hide');

            $('#myModal select:first').prop('disabled', false);
            $('#formRelation')[0].reset();


            if(modalstate == "add") {
                growl.success('SAVE_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            } else {
                growl.success('EDIT_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            }
        }, function(response) {
            //Second function handles error
            if (response.status == 400) {
                $scope.errors = response.data.error;
            } else if (response.status == 500) {


                //$('#myModal').modal('hide');
                //$('#formRelation')[0].reset();

                growl.error(response.data.error, {title: 'error!'});
            }
        });
    };*/

    $scope.remove = function(id) {
        var url = API_URL + "Relation_Type_remove/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $scope.getRelations();
        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
        });
    };

    $scope.getStates = function() {
        //Estado das propriedades
        $http.get('/properties/states').then(function(response) {
            $scope.states = response.data;
            console.log($scope.states);
        });
    };

    $scope.getEntities = function() {
        $http.get('/getAllEntities').then(function(response) {
            $scope.entities = response.data;
            console.log($scope.entities);
        });
    };

    $scope.getTransactionsTypes = function() {
        $http.get('/getAllTransactionTypes').then(function(response) {
            $scope.transactionTypes = response.data;
            console.log($scope.transactionTypes);
        });
    };

    $scope.getTransactionsStates = function() {
        $http.get('/getAllTransactionStates').then(function(response) {
            $scope.transactionStates = response.data;
            console.log($scope.transactionStates);
        });
    };


    $scope.openModalRelTypes = function (size, modalstate, id, parentSelector) {

        //$('#formRelation')[0].reset();
        $scope.relation = null;
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                console.log(id);
                $http.get(API_URL + '/getRelationsTypes/' + id)
                    .then(function(response) {
                        $scope.relation = response.data;
                    });
                break;
            default:
                break;
        }
        //$('#myModal').modal('show');
        //$scope.errors = null;

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalrelType',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            //alert("modal closed");
        });
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {
        var url      = API_URL + "Relation";

        console.log(jQuery('#formRelation').serializeArray());

        var formData = JSON.parse(JSON.stringify(jQuery('#formRelation').serializeArray()));

        console.log(formData);

        if (modalstate === 'edit') {
            url += "/" + id ;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param(formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            //First function handles success
            $scope.errors = [];
            $scope.getRelations();
            //$('#myModal').modal('hide');

            $scope.cancel();

            $('#myModal select:first').prop('disabled', false);
            $('#formRelation')[0].reset();


            if(modalstate == "add") {
                growl.success('SAVE_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            } else {
                growl.success('EDIT_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            }
        }, function(response) {
            //Second function handles error
            if (response.status == 400) {
                $scope.errors = response.data.error;
            } else if (response.status == 500) {


                //$('#myModal').modal('hide');
                //$('#formRelation')[0].reset();

                $scope.cancel();

                growl.error(response.data.error, {title: 'error!'});
            }
        });
    };
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

}).directive('pagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRelations(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRelations(currentPage-1)">&lsaquo; [[ "BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getRelations(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRelations(currentPage+1)">[[ "BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRelations(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});

