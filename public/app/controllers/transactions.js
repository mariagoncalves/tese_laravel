/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('transactionsController', function($scope, $http, growl, API_URL) {
    $scope.procs = function() {
        $http.get(API_URL + "/processes/get_processes")
            .then(function (response) {
                $scope.processes = response.data;
            });
    };

    $scope.transacsTypes = function() {
        $http.get(API_URL + "/processes/get_transacs_types")
            .then(function (response) {
                $scope.transactiontypes = response.data;
            });
    };

    $scope.processtypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $scope.getTransacs = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        //Process_Type
        $http.get('/transacs/get_transacs?page='+pageNumber).then(function(response) {
            $scope.transactions = response.data.data; //quando é procurado do processtypes para a linguagem
            //$scope.processtypes = response.data.data[0].process_type; quando é procurado da linguagem para o processtypes
            //alert(response.data.data[0].language[0].pivot.name);
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

    $scope.procs();
    $scope.transacsTypes();
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Adicionar Nova Transacção";
                break;
            case 'edit':
                $scope.form_title = "Detalhes da Transacção";
                $scope.id = id;
                $http.get(API_URL + 'transacs/get_transacs/' + id)
                    .then(function(response) {
                        $scope.transaction = response.data;
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.transaction = null;
    };


    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "Transaction";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({
                'transaction_type_id': $scope.transaction.transaction_type_id,
                'process_id': $scope.transaction.process_id,
                'state': $scope.transaction.state}
                ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getTransacs();
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
}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacs(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacs(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getTransacs(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacs(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacs(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});