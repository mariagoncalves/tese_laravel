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
    $scope.operators = [];
    $scope.propAllowedValues = [];
    $scope.fkEnt = [];
    $scope.entRefs = []; 

    $scope.getEntities = function () {

        $http.get('/dynamicSearch/entities').then(function(response) {
            $scope.entities = response.data;
            console.log($scope.entities);
        });
    }

    $scope.teste = function (id) {

        console.log("O id ta funcionando_: " + id + " Funciona mesmo?");
    }

    $scope.getEntitiesData = function (id) {

        console.log(id);

        $http.get(API_URL + '/dynamicSearch/entity/' + id)
                    .then(function(response) {
                        $scope.ents = response.data;
                        console.log('dados dos ents: ');
                        console.log($scope.ents);
                    });
    }

    $scope.getOperators = function () {

        //console.log("tá avor");

        $http.get('/dynamicSearch/getOperators').then(function(response) {
            $scope.operators = response.data;
            console.log($scope.operators);
        });
    }

    $scope.getEnumValues = function (id) {

        //console.log("tá avir fdddfd" + id);

        $http.get(API_URL + '/dynamicSearch/getEnumValues/' + id).then(function(response) {
            $scope.propAllowedValues = response.data;
            console.log($scope.propAllowedValues);
        });
    }

    $scope.getEntityInstances = function (entityId, propId) {

        console.log("tá a vir e o id da Entity é " + entityId + " e o id da prop é: " + propId);

        $http.get(API_URL + '/dynamicSearch/getEntityInstances/' + entityId + '/' + propId).then(function(response) {
            $scope.fkEnt = response.data[0];
            console.log("Dados instancias");
            console.log($scope.fkEnt);
        });
    }

    $scope.getEntRefs = function (id) {

        //console.log("teste com id: " + id);

        $http.get(API_URL + '/dynamicSearch/getEntRefs/' + id).then(function(response) {
            $scope.entRefs = response.data;
            console.log("Ddos das ent refs");
            console.log($scope.entRefs);
        });
    }
});

