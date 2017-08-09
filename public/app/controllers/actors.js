
app.controller('actorsController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService) {
    $translatePartialLoader.addPart('actors');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };


    $scope.type_class = "fa fa-fw fa-sort";
    $scope.type = 'ASC';
    $scope.input = null;
    $scope.num = null;
    var fil_sort = false;
    $scope.sort = function(input,num) {
        $scope.input = input;
        $scope.num = num;
        if ($scope.type == 'ASC' || $scope.type == 'DESC')
            fil_sort = true;

        if ($scope.type == 'ASC')
        {
            $scope.type_class = 'fa fa-fw fa-sort-asc';
            $scope.type = 'DESC';
        }
        else
        {
            $scope.type_class = 'fa fa-fw fa-sort-desc';
            $scope.type = 'ASC';
        }

        $scope.getActors(input);
    };

    $scope.actors = function() {
        $http.get(API_URL + "/get_actors")
            .then(function (response) {
                $scope.actors = response.data;
            });
    };

    $scope.actors = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.actor = [];
    $scope.actor_roles = [];

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_id, this.search_name, this.search_updated_at ];
        fil = MyService.filter(x);
        $scope.getActors();
    };



    $scope.getActors = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }

        var url='';
        if (fil === true)
        {
            if ($scope.search_id)
                url += '&s_id=' + $scope.search_id;

            if ($scope.search_name)
                url += '&s_name=' + $scope.search_name;

            if ($scope.search_updated_at)
                url += '&s_updated_at=' + $scope.search_updated_at;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }


        //Process_Type
        $http.get('/get_actors/?page='+pageNumber+url).then(function(response) {
            $scope.actors = response.data.data; //quando é procurado do processtypes para a linguagem
            //$scope.processtypes = response.data.data[0].process_type; quando é procurado da linguagem para o processtypes
            //alert(response.data.data[0].language[0].pivot.name);
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
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Adding New Actor";
                $scope.btn_label = "Save";

                break;
            case 'edit':
                $scope.form_title = "Editing Actor";
                $scope.btn_label = "Save Edit";
                $scope.id = id;
                $http.get(API_URL + 'get_actors/' + id)
                    .then(function(response) {
                        $scope.actor = response.data;
                    });
                break;
            case 'remove':
                $scope.id = id;
                $scope.btn_label = "Remove Actor";
                $scope.form_title = "Removing Actor";
                $http.get(API_URL + 'get_actors/' + id)
                    .then(function(response) {
                        $scope.actor = response.data;
                    });
                break;
            case 'view_roles':
                $scope.id = id;
                $scope.btn_label = "Exit";
                $scope.form_title = "Roles of This Actor";
                $http.get(API_URL + 'get_actors/' + id)
                    .then(function(response) {
                        $scope.actor = response.data;
                    });
                $http.get(API_URL + '/actors/get_selroles/' + id)
                    .then(function(response) {
                        $scope.selroles = response.data;
                    });
                break;

            case 'add_roles':
                $scope.id = id;
                $scope.btn_label = "Assign Roles to Actor";
                $scope.form_title = "Assigning Roles to Actor";
                $http.get(API_URL + 'get_actors/' + id)
                    .then(function(response) {
                        $scope.actor = response.data;
                    });
                $http.get(API_URL + '/actors/get_roles')
                    .then(function(response) {
                        $scope.roles = response.data;
                    });
                $http.get(API_URL + '/actors/get_selroles/' + id)
                    .then(function(response) {
                        $scope.selroles = response.data;
                    });
                break;

            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.removerole = function(actorid, roleid) {
        var url = API_URL + "remove_actor_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'actor_id' : actorid,
                    'role_id' : roleid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/actors/get_selroles/' + actorid)
                .then(function(response) {
                    $scope.selroles = response.data;
                });

        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
        });
    };



    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "actors";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'remove') {
            url += "/remove/" + id;
        }


        if (modalstate === 'edit') {
            url += "/" + id;
        }

        if(modalstate === 'add_roles') {

            url += "/update_roles/" + id;

            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'actor_id' : $scope.actor.id,
                        'selectedRoles' : $("#roleselect").val(),
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
                // $('#myModal').modal('hide');
                // $scope.getActors();
                $scope.toggle('view_roles', id);
            }, function errorCallback(response) {
                if (response.status == 400)
                {
                    growl.error('This is error message.',{title: 'error!'});
                }
                else
                {
                    $scope.errors = response.data;
                }
                //console.log(response);
            });

        } else{

        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    // 'language_id' : $scope.language.id,
                    'actor_id' : $scope.actor.id,
                    'name': $scope.actor.name,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getActors();
        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
            //console.log(response);
        });
        }
    };



}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getActors(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getActors(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getActors(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getActors(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getActors(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});

