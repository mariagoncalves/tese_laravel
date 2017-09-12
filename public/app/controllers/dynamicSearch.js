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
    $scope.propsOfEnts = [];
    $scope.relsWithEnt = [];


    $scope.getEntities = function () {

        $http.get('/dynamicSearch/entities').then(function(response) {
            $scope.entities = response.data;
            console.log($scope.entities);
        });
    }

    $scope.getEntitiesData = function (id) {

        console.log(id);

        $http.get(API_URL + '/dynamicSearch/entity/' + id)
                    .then(function(response) {
                        $scope.ents = response.data;
                        console.log('Get Entities Data: ');
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

        console.log("getEntityInstances: o id da Entity é " + entityId + " e o id da prop é: " + propId);

        $http.get(API_URL + '/dynamicSearch/getEntityInstances/' + entityId + '/' + propId).then(function(response) {
            $scope.fkEnt = response.data[0];
            console.log("Dados instancias getEntityInstances");
            console.log($scope.fkEnt);
        });
    }

    $scope.getEntRefs = function (id) {

        //console.log("teste com id: " + id);

        $http.get(API_URL + '/dynamicSearch/getEntRefs/' + id).then(function(response) {
            $scope.entRefs = response.data;
            console.log("Dados das ent refs");
            console.log($scope.entRefs);
        });
    }

    $scope.getPropsOfEnts = function (id) {

        console.log("teste com id getPropsOfEnts: " + id);

        $http.get(API_URL + '/dynamicSearch/getPropsOfEnts/' + id).then(function(response) {
            $scope.propsOfEnts = response.data;
            console.log("Ddos getPropsOfEnts");
            console.log($scope.propsOfEnts);
        });
    }

    $scope.getRelsWithEnt = function (id) {

        console.log("teste com id getRelsWithEnt: " + id);

        $http.get(API_URL + '/dynamicSearch/getRelsWithEnt/' + id).then(function(response) {
            $scope.relsWithEnt = response.data;
            console.log("Ddos relsWithEnt");
            console.log($scope.relsWithEnt);
        });
    }

    $scope.entRelated = function (ent_type1) {

        console.log("tá a vir e o id da ENT1 é " + ent_type1 + " e o id da ENT2é: " + "fd");

        /*$http.get(API_URL + '/dynamicSearch/getEntityInstances/' + entityId + '/' + propId).then(function(response) {
            $scope.fkEnt = response.data[0];
            console.log("Dados instancias");
            console.log($scope.fkEnt);
        });*/
    }
});

