/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('languagesController', function($scope, $http, growl, API_URL) {

    $scope.languages = function() {
        $http.get(API_URL + "/get_languages")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };


    $scope.languages = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $scope.getLanguages = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        //Process_Type
        $http.get('/get_languages/?page='+pageNumber).then(function(response) {
            $scope.languages = response.data.data; //quando é procurado do processtypes para a linguagem
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
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Adding New Language";
                $scope.btn_label = "Save";
                break;
            case 'edit':
                $scope.form_title = "Editing Language";
                $scope.btn_label = "Save Edit";
                $scope.id = id;
                $http.get(API_URL + 'get_languages/' + id)
                    .then(function(response) {
                        $scope.language = response.data;
                    });
                break;
            case 'remove':
                $scope.id = id;
                $scope.btn_label = "Remove Language";
                $scope.form_title = "Removing Language";
                $http.get(API_URL + 'get_languages/' + id)
                    .then(function(response) {
                        $scope.language = response.data;
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


    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "languages";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'remove') {
            url += "/remove/" + id;
        }


        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'language_id' : $scope.language.id,
                    'name': $scope.language.name,
                    'slug': $scope.language.slug,
                    'state': $scope.language.state,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getLanguages();
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
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getLanguages(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getLanguages(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getLanguages(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getLanguages(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getLanguages(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});