app.controller('RelationTypesManagmentControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, $filter, NgTableParams, MyService, $uibModal, $timeout) {

    $scope.entities = [];
    $scope.transactionTypes = [];
    $scope.transactionStates = [];
    $scope.errors = [];

    $translatePartialLoader.addPart('relTypes');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en") {
            $translate.use('pt');
        } else {
            $translate.use('en');
        }
    };

    $scope.remove = function(id) {
        var url = API_URL + "Relation_Type_remove/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            // Atualizar os dados da tabela
            $scope.getRelationsTable();
        }, function errorCallback(response) {
            if (response.status == 400 || response.status == 500){
                growl.error('This is error message.',{title: 'error!'});
            } else {
                $scope.errors = response.data;
            }
        });
    };

    $scope.getStates = function() {
        //Estado das propriedades
        $http.get('/properties/states').then(function(response) {
            $scope.states = response.data;
        });
    };

    $scope.getEntities = function() {
        $http.get('/getAllEntities').then(function(response) {
            $scope.entities = response.data;
        });
    };

    $scope.getTransactionsTypes = function() {
        $http.get('/getAllTransactionTypes').then(function(response) {
            $scope.transactionTypes = response.data;
        });
    };

    $scope.getTransactionsStates = function() {
        $http.get('/getAllTransactionStates').then(function(response) {
            $scope.transactionStates = response.data;
        });
    };

    $scope.openModalRelTypes = function (size, modalstate, id, parentSelector) {

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalrelType',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            resolve: {}
        }).rendered.then(function() {
            $scope.relation   = null;
            $scope.modalstate = modalstate;

            switch (modalstate) {
                case 'add':
                    $scope.id = id;
                    $scope.form_title = "ADD_FORM_NAME";
                    break;
                case 'edit':
                    $scope.form_title = "EDIT_FORM_NAME";
                    $scope.id = id;

                    $http.get(API_URL + '/getRelationsTypes/' + id)
                        .then(function(response) {
                            $scope.relation = response.data;
                            //$("[name=relation_name]").prop('disabled', 'disabled');
                        });
                    break;
                default:
                    break;
            }
        });
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {
            var url      = API_URL + "Relation";
            var formData = JSON.parse(JSON.stringify(jQuery('#formRelation').serializeArray()));

            if (modalstate === 'edit') {
                url += "/" + id ;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param(formData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(response) {
                $scope.errors = [];
                // Actualizar os dados da tabela
                $scope.getRelationsTable();
                // Fechar o popup
                $scope.cancel();

                $('#myModal select:first').prop('disabled', false);
                $('#formRelation')[0].reset();

                if (modalstate == "add") {
                    growl.success('SAVE_SUCCESS_MESSAGE', {title: 'SUCCESS'});
                } else {
                    growl.success('EDIT_SUCCESS_MESSAGE', {title: 'SUCCESS'});
                }
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {
                    $scope.cancel();
                    growl.error(response.data.error, {title: 'error!'});
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss();
        };
    };
    
    // Serve para inicializar o ng-table
    $scope.getRelationsTable = function() {
        var initialParams = {
            sorting: { created_at: "desc" }, // Ordenação por defeito da tabela
            count: 5, // Número de dados por página na tabela
        };

        var initialSettings = {
            counts: [5, 10, 15], // Número possiveis de apresentação dos dados da tabela
            getData: function (params) {
                var filterObj = params.filter(),
                    sortObj   = params.sorting();

                return $scope.getRelationTypes(params, filterObj, sortObj);
            }
        };

        $scope.tableParams = new NgTableParams(initialParams, initialSettings);
    };

    // Este método serve para ir buscar os dados da tabela
    $scope.getRelationTypes = function(params, filter, sort) {
        var url = '/relTypes/get_relation_types1?page=' + params.page();

        url += '&count=' + params.count();

        // Parametro de pesquisa quando é pesquisado pelo nome da relação
        if (filter.relationFilter != undefined && filter.relationFilter != '') {
            url += '&relation=' + filter.relationFilter;
        }
        // Parametro de pesquisa quando é pesquisado pelo nome da entidade 1
        if (filter.entity1Filter != undefined && filter.entity1Filter != '') {
            url += '&entity1=' + filter.entity1Filter;
        }
        // Parametro de pesquisa quando é pesquisado pelo nome da entidade 2
        if (filter.entity2Filter != undefined && filter.entity2Filter != '') {
            url += '&entity2=' + filter.entity2Filter;
        }
        // Parametro de pesquisa quando é pesquisado pelo nome da transação
        if (filter.transTypeFilter != undefined && filter.transTypeFilter != '') {
            url += '&transType=' + filter.transTypeFilter;
        }
        // Parametro de pesquisa quando é pesquisado pelo nome do estado da transação
        if (filter.transStateFilter != undefined && filter.transStateFilter != '') {
            url += '&transState=' + filter.transStateFilter;
        }
        // Parametro de pesquisa quando é pesquisado pelo estado do rel_type
        if (filter.stateFilter != undefined && filter.stateFilter != '') {
            url += '&state=' + filter.stateFilter;
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
});

