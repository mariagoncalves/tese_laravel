app.controller('dynamicSearchControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {

    /*$translatePartialLoader.addPart('properties');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };*/

    $scope.entities = [];
    $scope.ents = [];

    $scope.getEntities = function () {

        $http.get('/dynamicSearch/entities').then(function(response) {
            $scope.entities = response.data;
            console.log($scope.entities);
        });
    }

    /*$scope.getEntitiesData = function (id) {

        $scope.id = id;
        console.log(id);

        $http.get(API_URL + '/dynamicSearch/selectEntity/' + id)
                    .then(function(response) {
                        $scope.ents = response.data;
                        console.log($scope.ents);
                    });

    }*/
});

