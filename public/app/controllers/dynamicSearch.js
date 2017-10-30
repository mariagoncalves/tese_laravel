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
    $scope.resultDynamincSearch = [];
    //Porque vou precisar do id da ent_Type no método inactiveActive
    $scope.idEntityType = [];
    $scope.state = [];
    $scope.propRefs = [];
    



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

    $scope.getPropRefs = function (id) {

        console.log("CHEIGOUUU ");
        console.log("teste com id: " + id);

        $http.get(API_URL + '/dynamicSearch/getPropRefs/' + id).then(function(response) {
            $scope.entRefs = response.data;
            console.log("Dados das prop refs");
            console.log($scope.entRefs);
        });
    }


    $scope.clickTable1 = function ($event) {
        // Verificar se existe alguma checkbox selecionada na tabela 1
        var existeChecked = false;
        $("#table1").find("[type=checkbox]").each(function(index) {
            if ($(this).is(":checked")) {
                existeChecked = true;
                return;
            }
        });

        // Se existir, então vamos desbloquear todos os campos da tabela 2.
        // Caso contrario, bloquear.
        if (existeChecked) {
            $("#checkRL").find("[type=checkbox], [type=text], [type=number], [type=radio], select").removeAttr('disabled');
            $("#table4").find("[type=checkbox], [type=text], [type=number], [type=radio], select").removeAttr('disabled');
        } else {
            $("#checkRL").find("[type=checkbox]").prop("checked", false);
            $("#checkRL").find("[type=checkbox], [type=text], [type=number], [type=radio], select").attr('disabled', true);
        }
    }

    $scope.clickTable2 = function ($event) {
        // Verificar se existe alguma checkbox selecionada na tabela 2
        var existeChecked = false;
        $("#checkRL").find("[type=checkbox]").each(function(index) {
            if ($(this).is(":checked")) {
                existeChecked = true;
                return;
            }
        });

        // Se existir, então vamos bloquear todos os campos da tabela 3 e 4.
        // Caso contrario, desbloquear.
        if (existeChecked) {
            $("#table3, #table4").find("[type=checkbox]").prop("checked", false);
            $("#table3, #table4").find("[type=checkbox], [type=text], [type=number], [type=radio], select").attr('disabled', true);
        } else {
            $("#table3, #table4").find("[type=checkbox], [type=text], [type=number], [type=radio], select").removeAttr('disabled');
        }
    }

    $scope.clickTable3 = function ($event) {
        // Verificar se existe alguma checkbox selecionada na tabela 3
        var existeCheckedTable3 = false;
        $("#table3").find("[type=checkbox]").each(function(index) {
            if ($(this).is(":checked")) {
                existeCheckedTable3 = true;
                return;
            }
        });

        // Se existir, então vamos desbloquear todos os campos da tabela 4.
        // Caso contrario, bloquear.
        /*if (existeCheckedTable3) {
            $("#table4").find("[type=checkbox], [type=text], [type=number], [type=radio], select").removeAttr('disabled');
        } else {
            $("#table4").find("[type=checkbox]").prop("checked", false);
            $("#table4").find("[type=checkbox], [type=text], [type=number], [type=radio], select").attr('disabled', true);
        }*/

        var existeCheckedTable1 = false;
        $("#table1").find("[type=checkbox]").each(function(index) {
            if ($(this).is(":checked")) {
                existeCheckedTable1 = true;
                return;
            }
        });

        if ((existeCheckedTable1 && existeCheckedTable3) || existeCheckedTable3) {
            $("#checkRL").find("[type=checkbox]").prop("checked", false);
            $("#checkRL").find("[type=checkbox], [type=text], [type=number], [type=radio], select").attr('disabled', true);
        } else {
            $("#checkRL").find("[type=checkbox], [type=text], [type=number], [type=radio], select").removeAttr('disabled');
        }
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

    $scope.search = function (idEntityType) {

        $scope.idEntityType = idEntityType;

        console.log("ID DA ENTIDADE: " + idEntityType);

        var formData   = JSON.parse(JSON.stringify($('#dynamic-search').serializeArray())),
            numChecked = $('#dynamic-search').find('[type=checkbox]:checked').length,
            numTableET = 0,
            numTableVT = 0,
            numTableRL = 0,
            numTableER = 0;

        console.log("Valores do form DATA");
        console.log(formData);
        //console.log("Numero de checks");
        //console.log(numChecked);

        // Para saber quantas propriedades tem em cada tabela
        if ($scope.ents.properties != '' && $scope.ents.properties != undefined) {
            numTableET = $scope.ents.properties.length;
        }
        if ($scope.entRefs != '' && $scope.entRefs != undefined) {
            var len = $scope.entRefs.length;
            for (var i = 0; i < len; i++) {
                numTableVT = numTableVT + $scope.entRefs[i].properties.length;
            }
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

        //Acrescento ao form data o nr de propriedades existente em cada tabela
        formData.push({'name': 'numTableET', 'value': numTableET});
        formData.push({'name': 'numTableVT', 'value': numTableVT});
        formData.push({'name': 'numTableRL', 'value': numTableRL});
        formData.push({'name': 'numTableER', 'value': numTableER});
        formData.push({'name': 'numChecked', 'value': numChecked});

        console.log("SEGUNDOS VALORES DO FORMDATA");
        console.log(formData);

        $http({
            method: 'POST',
            url: API_URL + "dynamicSearch/search/" + idEntityType,
            data: $.param(formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log("RESUL FINAL");
            console.log(response);
            $scope.resultDynamincSearch = response.data;
            $("#dynamic-search").hide();
            $("#dynamic-search-presentation").show();
        });
    }

    $scope.voltar = function() {
        $("#dynamic-search").show();
        $("#dynamic-search-presentation").hide();
    }

     
    $scope.inactiveActive = function(idEntity) {

        console.log("Id da entidadeeee");
        console.log(idEntity);

        $http.post(API_URL + '/dynamicSearch/inactiveActive/' + idEntity).then(function(response) {
            console.log("Chegou");
            console.log(response.data);
            $scope.state = response.data;
            $scope.search($scope.idEntityType);
            growl.success('A instância foi ' + ($scope.state == 'active' ? 'Desativada' : 'Ativada' + '.'),{title: 'Success!'});
        });
    }

    $scope.saveSearch = function () {
        
    }


});

