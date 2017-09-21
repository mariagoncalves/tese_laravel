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
    $scope.entsRelated = [];
    $scope.propsEntRelated = [];
    $scope.information = [];


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
            $scope.propAllowedValues[id] = response.data;
            console.log("Prop Allowed value");
            console.log($scope.propAllowedValues);
        });
    }

    $scope.getEntityInstances = function (entityId, propId) {

        console.log("getEntityInstances: o id da Entity é " + entityId + " e o id da prop é: " + propId);

        $http.get(API_URL + '/dynamicSearch/getEntityInstances/' + entityId + '/' + propId).then(function(response) {
            $scope.fkEnt[propId] = response.data[0];
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
            $scope.propsOfEnts[id] = response.data;
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

    $scope.getEntsRelated = function (idRelType, idEntType) {

        console.log("ID RELATION: " + idRelType);
        console.log("ID ENTIDADE: " + idEntType);

        $http.get(API_URL + '/dynamicSearch/getEntsRelated/' + idRelType + '/' + idEntType).then(function(response) {
            $scope.entsRelated = response.data;
            console.log("Dados entsRelated TETETE: ");
            console.log($scope.entsRelated);
        });
    }

    $scope.getPropsEntRelated = function (id) {

        console.log("ID da entidade relacionada: " + id);

        $http.get(API_URL + '/dynamicSearch/getPropsEntRelated/' + id).then(function(response) {
            $scope.propsEntRelated = response.data[0];
            console.log("Dados propsEntRelated");
            console.log($scope.propsEntRelated);
        });
    }

    $scope.pesquisa = function (id) {

        console.log("ID da PESQUISAAA: " + id);

        var en2 = $("#checkProps").is(":checked");

        $http.get(API_URL + '/dynamicSearch/pesquisa/' + id).then(function(response) {
            $scope.information = response.data[0];
            console.log("Dados information");
            console.log($scope.information);
        });
    }


});

