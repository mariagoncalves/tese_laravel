app.controller('propertiesOfEntitiesManagmentControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {

    $translatePartialLoader.addPart('properties');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

	$scope.entities = [];
    $scope.states   = [];
    $scope.valueTypes = [];
    $scope.fieldTypes = [];
    $scope.units = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.errors = [];
    $scope.propsEnt = [];
    $scope.propEntity = [];
    $scope.select2PropEntity = [];
    //$scope.languages = [];
    $scope.props = [];

    $scope.getEntities = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        $http.get('/properties/get_props_ents?page='+pageNumber).then(function(response) {
            console.log(response);
            $scope.entities = response.data.data;

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

    /*$scope.toggle = function(modalstate, id) {
        $('#formProperty')[0].reset();
        $scope.property = null;
        $scope.modalstate = modalstate;

        if(modalstate == "edit") {
            $('#myModal select:first').prop('disabled', true);
        } else {
            $('#myModal select:first').prop('disabled', false);
        }

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Add New Property";
                break;
            case 'edit':
                $scope.form_title = "Edit Property";
                $scope.id = id;
                $http.get(API_URL + '/properties/get_property/' + id)
                    .then(function(response) {
                        $scope.property = response.data;
                    });
                break;
            default:
                break;
        }
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };*/

    /*$scope.save = function(modalstate, id) {
        var url      = API_URL + "PropertyEnt";


        console.log(jQuery('#formProperty').serializeArray());

        var formData = JSON.parse(JSON.stringify(jQuery('#formProperty').serializeArray()));

        console.log(formData);

        if (modalstate === 'edit') {
            url += "/" + id ;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param(formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            //First function handles success
            $scope.errors = [];
            $scope.getEntities();
            $('#myModal').modal('hide');

            $('#myModal select:first').prop('disabled', false);
            $('#formProperty')[0].reset();


            if(modalstate == "add") {
                growl.success('SAVE_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            } else {
                growl.success('EDIT_SUCCESS_MESSAGE',{title: 'SUCCESS'});
            }
        }, function(response) {
            //Second function handles error
            if (response.status == 400) {
                $scope.errors = response.data.error;
            } else if (response.status == 500) {


                $('#myModal').modal('hide');
                $('#formProperty')[0].reset();


                growl.error(response.data.error, {title: 'error!'});
            }
        });
    };*/

    $scope.showDragDropWindowEnt = function(id) {

        $scope.id = id;
        console.log(id);
        $scope.form_title = "Drag and Drop Properties";
        $http.get(API_URL + '/properties/getPropsEntity/' + id)
                    .then(function(response) {
                        $scope.propsEnt = response.data.properties;
                        console.log($scope.propsEnt);
                    });
        $('#myModal2').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.sortableOptionsEnt = {
        stop: function(e, ui) {
            console.log("DAR A AÇÃO PARA GUARDAR A ORDEM NA BASE DE DADOS.");

            console.log($(".list-group").find('.list-group-item').data('id'));

            var content = [];
            $(".list-group").find('.list-group-item').each(function( index ) {
                //content.push($(this).data('id'));
                content.push($(this).data('id'));
            });
            console.log(content);
            console.log("Chegou até aqui");
            var formData = JSON.parse(JSON.stringify(content));
            var url      = API_URL + "updateOrderEnt";

            $http({
                method: 'POST',
                url: url,
                data: formData,
            }).then(function(response) {
                console.log('Success!');
                $scope.getEntities();
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {
                    growl.error('Error.', {title: 'error!'});
                }
            });
        }
    };

    $scope.getStates = function() {
        //Estado das propriedades
        $http.get('/properties/states').then(function(response) {
            $scope.states = response.data;
            console.log($scope.states);
        });
    };

    $scope.getValueTypes = function() {
        //Buscar value types
        $http.get('/properties/valueTypes').then(function(response) {
            $scope.valueTypes = response.data;
            console.log($scope.valueTypes);
        });
    };

    $scope.getFieldTypes = function() {
        //Buscar fields types
        $http.get('/properties/fieldTypes').then(function(response) {
            $scope.fieldTypes = response.data;
            console.log($scope.fieldTypes);
        });
    };

    $scope.getUnits = function() {

        $http.get('/properties/units').then(function(response) {
            $scope.units = response.data;
            console.log($scope.units);

        });
    };

    $scope.openModalPropsEnt = function (size, modalstate, id, parentSelector) {

        //$('#formProperty')[0].reset();
        $scope.property = null;
        $scope.modalstate = modalstate;

        /*if(modalstate == "edit") {
            //$("[name=entity_type]").prop('disabled', 'disabled');
            //$("entity_type").attr('disabled', 'disabled');
            //$("input:text[name=entity_type]").prop("readonly", true);
            //$("#entity_type").prop('disabled', 'disabled');
            //$('#entity_type').prop('readonly', true);

            console.log("Tá a entar");
        } else {
            $("[name=entity_type]").removeAttr("disabled");
            console.log("Não entra");
        }*/

        if(modalstate == "add") {
            //$("[name=entity_type]").removeAttr("disabled");
            //$("#entity_type").removeAttr("disabled");
            //$("#formProperty entity_type").removeAttr("disabled");
            //$("#entity_type").prop('disabled', false);
            //$("entity_type").removeAttr("disabled");
            //$("#formProperty select:first").removeAttr("disabled");

            //Desbloquear o nome da entidade
            $("entity_type").prop('disabled', false);

            //teste
            //$("#property_name").prop('disabled', 'disabled');

            console.log("Não entra");
        } else {


            //Caso seja editar e o value_type seja info, quero desbloquear a fk_entity e as 2 de multiselect já com as opções selecionadas antes

            //Este valor só vem quando altero a selectbox -.-
            var valType = $("#property_valueType option:selected").text();
            console.log(valType);

            /*if(valType == 'info') {

                $("[name=ent_types_select]").removeAttr("disabled");
                $("#propselect").removeAttr("disabled");
                $("[name=reference_entity]").removeAttr("disabled");
                $("[name=fk_property]").prop('disabled', 'disabled');

            } else if (valType == 'ent_ref') {

                $("[name=fk_property]").prop('disabled', 'disabled');
                $("#propselect").prop('disabled', 'disabled');
                $("[name=reference_entity]").removeAttr("disabled");
                $("[name=ent_types_select]").prop('disabled', 'disabled');

            } else if (valType == 'prop_ref') {
                
                $("[name=ent_types_select]").prop('disabled', 'disabled');
                $("[name=reference_entity]").removeAttr("disabled");
                $("#propselect").prop('disabled', 'disabled');
                $("[name=fk_property]").removeAttr("disabled");
                
            }*/
        }

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Add New Property";
                break;
            case 'edit':
                $scope.form_title = "Edit Property";
                $scope.id = id;

                $http.get(API_URL + '/properties/get_property/' + id)
                    .then(function(response) {
                        $scope.property = response.data;
                    });
                break;
            default:
                break;
        }

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalPropsEnt',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            //alert("modal closed");
        });
    };

    /*$scope.changedSelectEntitiesValue = function() {
        console.log("Alterou");
        var value = $("[name=entity_type]").val();
        console.log(value);
        //value = value.split(":")[1];

        if (value == '' || value == undefined) {
            $("[name=fk_property]").prop('disabled', 'disabled');
            $("#propselect").prop('disabled', 'disabled');

            $scope.propEntity = [];
            $scope.select2PropEntity = [];
        } else {
            $("[name=fk_property]").removeAttr("disabled");
            $("#propselect").removeAttr("disabled");

            $http.get('/properties/getPropsEntity/' + value).then(function(response) {
                console.log(response.data);
                $scope.propEntity = response.data;
                $scope.select2PropEntity = response.data;
            });
       }
    };*/

    $scope.changes = function() {

        console.log("Chegou aqui hello");
        //console.log(valueType);

        var valueType = $("[name=property_valueType]").val();
        console.log("Valor do valueType:");
        console.log(valueType);

        $http.get('/properties/get_all_Ents').then(function(response) {
            console.log("VALOR DO PEDIDO");
            console.log(response.data);
            $scope.ents = response.data;
            $scope.select2Ents = response.data;
        });

        if (valueType == 'ent_ref') {
            $("[name=fk_property]").prop('disabled', 'disabled');
            $("#propselect").prop('disabled', 'disabled');

            $("[name=reference_entity]").removeAttr("disabled");

            //Não sei se é para desbloquear
            //$("[name=ent_types_select]").removeAttr("disabled");
            //Se for para desbloquear
            $("[name=ent_types_select]").prop('disabled', 'disabled');

            //$("#checkProps").remove();
            //$("#checkEnts").remove();


        } else if (valueType == 'prop_ref') {
           
            //Multiselect de entidades fica bloqueado
            $("[name=ent_types_select]").prop('disabled', 'disabled');

            //Este fica desbloqueado para servir como filtro
            $("[name=reference_entity]").removeAttr("disabled");

            //Não sei se é para desbloquear
            //$("#propselect").removeAttr("disabled");
            //Se for para fica bloqueado
            $("#propselect").prop('disabled', 'disabled');

            $("[name=fk_property]").removeAttr("disabled");



            //$("input type:checkbox[name=checkProps]").remove();
            //$("#checkProps").remove();
            //$("#checkEnts").remove();

        } else if (valueType == 'info') {

            //Desbloquear
            $("[name=ent_types_select]").removeAttr("disabled");
            $("#propselect").removeAttr("disabled");
            $("[name=reference_entity]").removeAttr("disabled");

            //Bloquear
            $("[name=fk_property]").prop('disabled', 'disabled');

            //Acrescentar coisas
            //$("#propselect").before("<input type = 'checkbox' name = 'checkProps' id = 'checkProps'>");
            //$("#propselect").prepend("Alguma coisa");
            //$("#ent_types_select").before("<input type = 'checkbox' name = 'checkEnts'  id = 'checkEnts'>");




            //var en = $("#checkEnts").is(":checked");
            //console.log("Valor do en: ");
            //console.log(en);
            //var en2 = $("#checkProps").is(":checked");

        } else {

            $("[name=fk_property]").prop('disabled', 'disabled');
            $("#propselect").prop('disabled', 'disabled');
            $("[name=reference_entity]").prop('disabled', 'disabled');
            $("[name=ent_types_select]").prop('disabled', 'disabled');

            //$("#checkProps").remove();
            //$("#checkEnts").remove();
        }
        
    };

    $scope.getPropsByEnt = function () {

        console.log("Tá a chegar ao teste");

        var value = $("[name=reference_entity]").val();
        value = value.split(":")[1];
        //var value = $("[name=entity_type]").val();
        console.log(value);

        $http.get('/properties/getPropsEntity/' + value).then(function(response) {
            console.log(response.data);
            $scope.propEntity = response.data;
            $scope.select2PropEntity = response.data;
        });

        //var teste = $("#fk_ent_type option:selected").val();
        //console.log(teste);

        //var entSel = $("reference_entity").val();
        //console.log(entSel);
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {
            var url      = API_URL + "PropertyEnt";

            console.log(jQuery('#formProperty').serializeArray());

            var formData = JSON.parse(JSON.stringify(jQuery('#formProperty').serializeArray()));

            //Para passar todos os valores escolhidos nos multiselect
            formData.push({'name': 'propselect', 'value': $("#propselect").val()});
            formData.push({'name' : 'ent_types_select', 'value': $("#ent_types_select").val()});

            console.log(formData);
            console.log($("#propselect").val());

            if (modalstate === 'edit') {
                url += "/" + id ;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param(formData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(response) {
                //First function handles success
                $scope.errors = [];
                $scope.getEntities();
               // $('#myModal').modal('hide');
               $scope.cancel();

                $('#myModal select:first').prop('disabled', false);
                //$('#formProperty')[0].reset();


                if(modalstate == "add") {
                    growl.success('SAVE_SUCCESS_MESSAGE',{title: 'SUCCESS'});
                } else {
                    growl.success('EDIT_SUCCESS_MESSAGE',{title: 'SUCCESS'});
                }
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {

                    //$('#myModal').modal('hide');
                    //$('#formProperty')[0].reset();
                    $scope.cancel();

                    growl.error(response.data.error, {title: 'error!'});
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

    $scope.remove = function(id) {
        var url = API_URL + "PropertyOfEntities_remove/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            console.log("lalal 11");
            console.log(response);
            growl.success('This is success message.',{title: 'Success!'});
            $scope.getEntities();
        }, function errorCallback(response) {
            console.log("lalal");
            console.log(response);
            if (response.status == 400 || response.status == 500)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
        });
    };

    
}).directive('pagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getEntities(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getEntities(currentPage-1)">&lsaquo; [[ "BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getEntities(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getEntities(currentPage+1)">[[ "BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getEntities(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});;

