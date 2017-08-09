
app.controller('rolesController', function($scope, $http, growl, API_URL, NgTableParams, MyService) {

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

        $scope.getRoles(input);
    };


    $scope.roles = function() {
        $http.get(API_URL + "/get_roles")
            .then(function (response) {
                $scope.roles = response.data;
            });
    };


    $scope.roles = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_id, this.search_name, this.search_updated_at ];
        fil = MyService.filter(x);
        $scope.getRoles();
    };

    $scope.getRoles = function(pageNumber) {

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
        $http.get('/get_roles/?page='+pageNumber+url).then(function(response) {
            $scope.roles = response.data.data; //quando é procurado do processtypes para a linguagem
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
                $scope.form_title = "Adding New Role";
                $scope.btn_label = "Save";
                break;
            case 'edit':
                $scope.form_title = "Editing Role";
                $scope.btn_label = "Save Edit";
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                break;
            case 'remove':
                $scope.id = id;
                $scope.btn_label = "Remove Role";
                $scope.form_title = "Removing Role";
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                break;

            case 'view_actors':
                $scope.id = id;
                $scope.btn_label = "Exit";
                $scope.form_title = "Actors of This Role";
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_selactors/' + id)
                    .then(function(response) {
                        $scope.selactors = response.data;
                    });
                break;
            case 'view_users':
                $scope.id = id;
                $scope.btn_label = "Exit";
                $scope.form_title = "Users of This Role";
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_selusers/' + id)
                    .then(function(response) {
                        $scope.selusers = response.data;
                    });
                break;
            case 'add_actors':
                $scope.id = id;
                $scope.btn_label = "Assign Actors to Role";
                $scope.form_title = "Assigning Actors to Role";
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_actors')
                    .then(function(response) {
                        $scope.actors = response.data;
                    });
                $http.get(API_URL + '/roles/get_selactors/' + id)
                    .then(function(response) {
                        $scope.selactors = response.data;
                    });
                break;

            case 'add_users':
                $scope.id = id;
                $scope.btn_label = "Assign Users to Role";
                $scope.form_title = "Assigning Users to Role";
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_users')
                    .then(function(response) {
                        $scope.users = response.data;
                    });
                $http.get(API_URL + '/roles/get_selusers/' + id)
                    .then(function(response) {
                        $scope.selactors = response.data;
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

    $scope.removeactor = function(roleid, actorid) {
        var url = API_URL + "remove_actor_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'role_id' : roleid,
                    'actor_id' : actorid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/roles/get_selactors/' + roleid)
                .then(function(response) {
                    $scope.selactors = response.data;
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


    $scope.removeuser = function(roleid, userid) {
        var url = API_URL + "remove_user_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'role_id' : roleid,
                    'user_id' : userid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/roles/get_selusers/' + roleid)
                .then(function(response) {
                    $scope.selusers = response.data;
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
        var url = API_URL + "roles";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'remove') {
            url += "/remove/" + id;
        }


        if (modalstate === 'edit') {
            url += "/" + id;
        }

        if(modalstate === 'add_actors') {

            url += "/update_actors/" + id;

            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id' : $scope.role.id,
                        'selectedActors' : $("#actorselect").val(),
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
                // $('#myModal').modal('hide');
                // $scope.getActors();
                $scope.toggle('view_actors', id);
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

        } else if (modalstate === 'add_users') {

            url += "/update_users/" + id;

            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id' : $scope.role.id,
                        'selectedUsers' : $("#userselect").val(),
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
                // $('#myModal').modal('hide');
                // $scope.getActors();
                $scope.toggle('view_users', id);
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

        } else {

            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id': $scope.role.id,
                        'name': $scope.role.name,
                        // 'slug': $scope.role.slug,
                        // 'state': $scope.role.state,
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.', {title: 'Success!'});
                $('#myModal').modal('hide');
                $scope.getRoles();
            }, function errorCallback(response) {
                if (response.status == 400) {
                    growl.error('This is error message.', {title: 'error!'});
                }
                else {
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
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRoles(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRoles(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getRoles(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRoles(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRoles(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});