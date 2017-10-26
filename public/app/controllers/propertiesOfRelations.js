app.controller('propertiesOfRelationsManagmentControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, $filter, NgTableParams, MyService, $uibModal, $timeout) {

    $translatePartialLoader.addPart('properties');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.relations = [];
    $scope.states   = [];
    $scope.valueTypes = [];
    $scope.fieldTypes = [];
    $scope.units = [];
    //$scope.totalPages = 0;
    //$scope.currentPage = 1;
    //$scope.range = [];
    $scope.errors = [];
    $scope.propsRel = [];
    $scope.result = [];

    /*$scope.getRelations = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        //Properties
        $http.get('/properties/get_props_rel?page='+pageNumber).then(function(response) {
            console.log(response);
            $scope.relations = response.data.data;

            $scope.totalPages = response.data.last_page;
            $scope.currentPage = response.data.current_page;

            // Pagination Range
            var pages = [];

            for (var i = 1; i <= response.data.last_page; i++) {
                pages.push(i);
            }

            $scope.range = pages;

        });
    };*/

    /*$scope.toggleRel = function(modalstate, id) {
        $('#formPropRel')[0].reset();
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

    $scope.showDragDropWindow = function(id) {

        $scope.id = id;
        console.log(id);
        $scope.form_title = "Drag and Drop Properties";
        $http.get(API_URL + '/properties/getPropsRelation/' + id)
                    .then(function(response) {
                        $scope.propsRel = response.data.properties;
                        console.log($scope.propsRel);
                    });
        $('#myModal2').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.sortableOptions = {
        stop: function(e, ui) {
            console.log("AQUI DAR A AÇÃO PARA GUARDAR A ORDEM NA BASE DE DADOS.");

            //var dado = $(".list-group").find('.list-group-item').data('id');
            console.log($(".list-group").find('.list-group-item').data('id'));

            var content = [];
            $(".list-group").find('.list-group-item').each(function( index ) {
                //dados.push($(this).data('id'));
                content.push($(this).data('id'));
            });
            console.log(content);

            var formData = JSON.parse(JSON.stringify(content));
            var url      = API_URL + "updateOrder";

            $http({
                method: 'POST',
                url: url,
                data: formData,
            }).then(function(response) {
                console.log('Success!');
                $scope.getRelations();
                //growl.success('Order updated successfully.',{title: 'Success!'});
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

    $scope.openModalPropsRel = function (size, modalstate, id, parentSelector) {

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalPropsRel',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).rendered.then(function() {

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

        });
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.saveRel = function(modalstate, id) {

        var url      = API_URL + "PropertyRel";

        console.log(jQuery('#formPropRel').serializeArray());
        var formData = JSON.parse(JSON.stringify(jQuery('#formPropRel').serializeArray()));
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
            $scope.getPropsOfRelation();
            $scope.cancel();
            $('#myModal select:first').prop('disabled', false);

            // Mostrar mensagem de sucesso
            if(modalstate == "add") {
                growl.success('Property inserted successfully.',{title: 'Success!'});
            } else {
                growl.success('Property edited successfully.',{title: 'Success!'});
            }
        }, function(response) {
            //Second function handles error
            if (response.status == 400) {
                $scope.errors = response.data.error;
            } else if (response.status == 500) {
                //$('#myModal').modal('hide');
                //$('#formPropRel')[0].reset();
                $scope.cancel();
                growl.error('Error.', {title: 'error!'});
            }
        });
    };
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

    /*$scope.confirmRemove = function (id) {

        console.log("O id da prop é " + id);

        $('#modalConfirm').modal('show');

        $scope.remove = function(id) {

        console.log("Consigo ter aqui o id e é: " + id);
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
    };*/

    $scope.openModaConfirm = function (size, id, parentSelector) {

        console.log(id);

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalConfirm',
            controller: 'ModalInstanceCtrl2',
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

    $scope.ModalInstanceCtrl2 = function ($scope, $uibModalInstance) {

        $scope.remove = function(id) {

            console.log("Consigo ter aqui o id e é: " + id);
            /*var url = API_URL + "PropertyOfEntities_remove/" + id;

            $http({
                method: 'POST',
                url: url,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                console.log("lalal 11");
                console.log(response);
                growl.success('This is success message.',{title: 'Success!'});
                $scope.cancel();
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
            });*/
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };


    $scope.getRelations = function(){

        console.log("GET RELATIONS CHEGOU");

        $http.get('/properties/getAllRelations').then(function(response) {
            $scope.relations = response.data;
            console.log($scope.relations);
        });
    }


     //------------------------------------TESTES------------------------------
    //Para usar o ng-table

    /*$http.get('/propertiesOfRelation/get_propsOfRel1?page=1').then(function(response) {
        $scope.tableParams = new NgTableParams({
            count: 2,
            group: "name"
        }, {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: response.data

        });

        console.log(response.data);
    });*/

    //-------------------------------------------------------------------------

    $scope.getPropsOfRelation = function() {

        var initialParams = {
            sorting: { created_at: "desc" }, // Ordenação por defeito da tabela
            count: 5, // Número de dados por página na tabela
        };

        var initialSettings = {
            counts: [5, 10, 15], // Número possiveis de apresentação dos dados da tabela
            getData: function (params) {
                var filterObj = params.filter(),
                    sortObj   = params.sorting();

                return $scope.getPropsOfRel(params, filterObj, sortObj);
            }
        };

        $scope.tableParams = new NgTableParams(initialParams, initialSettings);
    };

    $scope.getPropsOfRel = function (params, filter, sort) {

        var url = '/propertiesOfRelation/get_propsOfRel1?page=' + params.page();

        url += '&count=' + params.count();

        // Parametro de pesquisa quando é pesquisado pelo nome da relação
        if (filter.relationFilter != undefined && filter.relationFilter != '') {
            url += '&relation=' + filter.relationFilter;
        }
        // Parametro de pesquisa quando é pesquisado pelo nome da propriedade
        if (filter.propertyFilter != undefined && filter.propertyFilter != '') {
            url += '&property=' + filter.propertyFilter;
        }

        var colSorting  = Object.keys(sort)[0],
            typeSorting = sort[colSorting];
        // Parametro para ordenar os dados
        url += '&colSorting=' + colSorting + "&typeSorting=" + typeSorting;

        return $http.get(url).then(function (response) {
                params.total(response.data.total);
                return response.data.data;
            });
    }

    
}).directive('pagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRelations(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRelations(currentPage-1)">&lsaquo; [[ "BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getRelations(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRelations(currentPage+1)">[[ "BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRelations(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});;

