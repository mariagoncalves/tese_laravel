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

        if(modalstate == "edit") {
            $('#myModal select:first').prop('disabled', true);
        } else {
            $('#myModal select:first').prop('disabled', false);
        }

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Add New Property";


                /*$http.get(API_URL + 'get_actors/' + id)
                    .then(function(response) {
                        $scope.actor = response.data;
                    });*/
                $http.get(API_URL + '/actors/get_roles')
                    .then(function(response) {
                        $scope.roles = response.data;
                    });
                $http.get(API_URL + '/actors/get_selroles/' + id)
                    .then(function(response) {
                        $scope.selroles = response.data;
                    });
    
                /*$http.get(API_URL + '/properties/getAllProps')
                    .then(function(response) {
                        console.log("OLHA AS PROPS");
                        $scope.props = response.data;
                        console.log($scope.props);
                    });*/

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

    $scope.changedSelectEntitiesValue = function() {
        console.log("Alterou");
        var value = $("[name=entity_type]").val();
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
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {
            var url      = API_URL + "PropertyEnt";

            console.log(jQuery('#formProperty').serializeArray());

            var formData = JSON.parse(JSON.stringify(jQuery('#formProperty').serializeArray()));

            formData.push({'name': 'propselect', 'value': $("#propselect").val()});
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

