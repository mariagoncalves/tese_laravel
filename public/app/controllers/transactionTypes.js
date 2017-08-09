/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('transactionTypesController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService) {
    $translatePartialLoader.addPart('transactionTypes');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.type_class = "fa fa-fw fa-sort";
    $scope.type = 'asc';
    $scope.input = null;
    $scope.num = null;
    var fil_sort = false;
    $scope.sort = function(input,num) {
        $scope.input = input;
        $scope.num = num;
        if ($scope.type == 'asc' || $scope.type == 'desc')
            fil_sort = true;

        if ($scope.type == 'asc')
        {
            $scope.type_class = 'fa fa-fw fa-sort-asc';
            $scope.type = 'desc';
        }
        else
        {
            $scope.type_class = 'fa fa-fw fa-sort-desc';
            $scope.type = 'asc';
        }

        $scope.getTransacsTypes(input);
    };

    $scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };

    $scope.procstypes = function() {
        $http.get(API_URL + "/proc_types/get_procs_types")
            .then(function (response) {
                $scope.processtypes = response.data;
            });
    };

    $scope.executers = function() {
        $http.get(API_URL + "/exec/get_executers")
            .then(function (response) {
                $scope.executers = response.data;
            });
    };


    $scope.processtypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $http.get('/transacs_types/get_transacs_types1?page=1').then(function(response) {
        $scope.tableParams = new NgTableParams({
            count: 2,
            group: "name"
        }, {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: response.data
        });
    });

    /*var fil = false;
    $scope.filter = function() {
        if(this.search_process_type || this.search_id || this.search_name || this.search_result_type || this.search_state || this.search_executer) {
            fil=true;
        }
        $scope.getTransacsTypes();
    };*/

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_process_type, this.search_id, this.search_name, this.search_result_type, this.search_state, this.search_executer ];
        fil = MyService.filter(x);
        $scope.getTransacsTypes();
    };

    $scope.getTransacsTypes = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }

        var url='';
        if (fil === true)
        {
            if ($scope.search_process_type)
                url += '&s_process_type=' + $scope.search_process_type;

            if ($scope.search_id)
                url += '&s_id=' + $scope.search_id;

            if ($scope.search_name)
                url += '&s_name=' + $scope.search_name;

            if ($scope.search_result_type)
                url += '&s_result_type=' + $scope.search_result_type;

            if ($scope.search_state)
                url += '&s_state=' + $scope.search_state;

            if ($scope.search_executer)
                url += '&s_executer=' + $scope.search_executer;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }
        //Process_Type

        $http.get('/transacs_types/get_transacs_types?page='+pageNumber+url).then(function(response) {
            $scope.transactiontypes = response.data.data; //quando é procurado do processtypes para a linguagem

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

    $scope.procstypes();
    $scope.langs();
    $scope.executers();
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        $scope.frmTransactionTypes.$setUntouched();

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                $http.get(API_URL + 'transacs_types/get_transacs_types/' + id)
                    .then(function(response) {
                        $scope.transactiontype = response.data;
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.delete = function(id) {
        var url = API_URL + "Transaction_Type_del/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getTransacsTypes();
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

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "Transaction_Type";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({ 'language_id' : $scope.transactiontype.language[0].id,
                't_name': $scope.transactiontype.language[0].pivot.t_name,
                'rt_name': $scope.transactiontype.language[0].pivot.rt_name,
                'process_type_id': $scope.transactiontype.process_type_id,
                'state': $scope.transactiontype.state,
                'executer' : $scope.transactiontype.executer_actor.language[0].pivot.actor_id
                }
                ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getTransacsTypes();
        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
            //console.log(response);
        });
    };
}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacsTypes(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacsTypes(currentPage-1)">&lsaquo; [["BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getTransacsTypes(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacsTypes(currentPage+1)">[["BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacsTypes(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});