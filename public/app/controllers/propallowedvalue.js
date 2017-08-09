/**
 * Created by Guilherme on 15/06/2017.
 */

app.controller('propAllowedValueController', function($scope, $http, API_URL, growl,$translatePartialLoader, $translate, MyService) {

    //Translate Function
    $translatePartialLoader.addPart('propAllowedValue');
    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };


    $scope.propUnitTypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $scope.getPropAllowedValues = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        //Process_Type
        $http.get('/prop_allowed_value/get_unit?page='+pageNumber).then(function(response) {
            $scope.propAllowedValues = response.data.data;
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

    $scope.props = function() {
        $http.get(API_URL + '/prop_allowed_value/get_properties')
            .then(function(response) {
                $scope.properties = response.data;
        });
    };
    $scope.props();

    //show modal form
    $scope.propAllowedValue = [];
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "EDIT_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                $http.get(API_URL + 'prop_allowed_value/get_unit/' + id)
                    .then(function(response) {
                        $scope.propAllowedValue = response.data;
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.propAllowedValue = null;
    };

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "Prop_Allowed_Value";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id ;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({'name' : $scope.propAllowedValue.language[0].pivot.name,
                'state' : $scope.propAllowedValue.state,
                'property_id' : $scope.propAllowedValue.property_id
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (modalstate === 'edit')
                growl.success('EDIT_SUCCESS_MESSAGE');
            else
                growl.success('SAVE_SUCCESS_MESSAGE');
            $('#myModal').modal('hide');
            $scope.getPropAllowedValues();
        },  function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
            //alert('This is embarassing. An error has occured. Please check the log for details');
        });
    };

}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getPropAllowedValues(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getPropAllowedValues(currentPage-1)">&lsaquo; [["BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getPropAllowedValues(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getPropAllowedValues(currentPage+1)">[["BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getPropAllowedValues(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});