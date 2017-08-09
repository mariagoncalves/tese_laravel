/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('CausalLinksController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, MyService) {
    $translatePartialLoader.addPart('causalLinks');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };

    $scope.transacstypes = function() {
        $http.get(API_URL + "/ents_types/get_transacs_types")
            .then(function (response) {
                $scope.transactionstype = response.data;
            });
    };

    $scope.tstates = function() {
        $http.get(API_URL + "/ents_types/get_tstates")
            .then(function (response) {
                $scope.tstates = response.data;
            });
    };

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_id, this.search_causing_t, this.search_t_state, this.search_caused_t ];
        fil = MyService.filter(x);
        $scope.getCausalLinks();
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

        $scope.getCausalLinks(input);
    };

    $scope.processtypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $scope.getCausalLinks = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }

        var url='';
        if (fil === true)
        {
            if ($scope.search_id)
                url += '&s_id=' + $scope.search_id;

            if ($scope.search_causing_t)
                url += '&s_causing_t=' + $scope.search_causing_t;

            if ($scope.search_t_state)
                url += '&s_t_state=' + $scope.search_t_state;

            if ($scope.search_caused_t)
                url += '&s_caused_t=' + $scope.search_caused_t;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }

        //Process_Type
        $http.get('/causal_links/get_causal_links?page='+pageNumber+url).then(function(response) {
            $scope.causallinks = response.data.data; //quando é procurado do processtypes para a linguagem
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

    $scope.transacstypes();
    $scope.langs();
    $scope.tstates();
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                $http.get(API_URL + 'causal_links/get_causal_links/' + id)
                    .then(function(response) {
                        $scope.causallink = response.data;
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.causallink = null;
    };


    $scope.delete = function(id) {
        var url = API_URL + "Causal_Link_del/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getCausalLinks();
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
        var url = API_URL + "Causal_Link";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({ 'causing_t' : $scope.causallink.causing_t,
                't_state_id': $scope.causallink.t_state_id,
                'caused_t': $scope.causallink.caused_t,
                'min': $scope.causallink.min,
                'max' : $scope.causallink.max
                }
                ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getCausalLinks();
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
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getCausalLinks(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getCausalLinks(currentPage-1)">&lsaquo; [[ "BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getCausalLinks(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getCausalLinks(currentPage+1)">[[ "BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getCausalLinks(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});