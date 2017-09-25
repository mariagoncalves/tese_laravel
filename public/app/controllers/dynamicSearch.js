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

    $scope.pesquisa = function (idEntityType) {
        console.log("ID DA ENTIDADE: " + idEntityType);

        var formData   = JSON.parse(JSON.stringify($('#dynamic-search').serializeArray())),
            numChecked = $('#dynamic-search').find('[type=checkbox]:checked').length,
            numTableET = 0,
            numTableVT = 0,
            numTableRL = 0,
            numTableER = 0;

        console.log("Numero de checks");
        console.log(numChecked);

        // Para saber quantas propriedades tem em cada tabela
        if ($scope.ents.properties != '' && $scope.ents.properties != undefined) {
            numTableET = $scope.ents.properties.length;
        }
        if ($scope.propsOfEnts[idEntityType] != '' && $scope.propsOfEnts[idEntityType] != undefined) {
            numTableVT = $scope.propsOfEnts[idEntityType].length;
        }
        if ($scope.relsWithEnt != '' && $scope.relsWithEnt != undefined) {
            var len = $scope.relsWithEnt.length;
            for (var i = 0; i < len; i++) {
                numTableRL = numTableRL + $scope.relsWithEnt[i].properties.length;
            }
        }
        if ($scope.entsRelated != '' && $scope.entsRelated != undefined) {
            var len = $scope.entsRelated.length;
            for (var i = 0; i < len; i++) {
                numTableER = numTableER + $scope.entsRelated[i].properties.length;
            }
        }

        console.log("numTableET");
        console.log(numTableET);
        console.log(numTableVT);
        console.log(numTableRL);
        console.log(numTableER);

        formData.push({'name': 'numTableET', 'value': numTableET});
        formData.push({'name': 'numTableVT', 'value': numTableVT});
        formData.push({'name': 'numTableRL', 'value': numTableRL});
        formData.push({'name': 'numTableER', 'value': numTableER});
        formData.push({'name': 'numChecked', 'value': numChecked});

        console.log(formData);
        $("#dynamic-search").hide();
        $("#dynamic-search-presentation").show();

        $http({
            method: 'POST',
            url: API_URL + "dynamicSearch/pesquisa/" + idEntityType,
            data: $.param(formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log("RESUL FINAL");
        });
    }

    $scope.voltar = function() {
        $("#dynamic-search").show();
        $("#dynamic-search-presentation").hide();
    }


});

