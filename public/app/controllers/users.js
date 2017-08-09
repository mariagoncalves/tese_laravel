/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('usersController', function($scope, $http, growl, API_URL, NgTableParams, MyService) {

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

        $scope.getUsers(input);
    };


    $scope.users = function() {
        $http.get(API_URL + "/get_users")
            .then(function (response) {
                $scope.users = response.data;
            });
    };

    $scope.langs = function() {
        $http.get(API_URL + "/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };


    $scope.user = [];
    $scope.users = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_id, this.search_name, this.search_email, this.search_user_name, this.search_languageslug, this.search_user_type, this.search_entity, this.search_updated_at ];
        fil = MyService.filter(x);
        $scope.getUsers();
    };

    $scope.getUsers = function(pageNumber) {

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

            if ($scope.search_email)
                url += '&s_email=' + $scope.search_email;

            if ($scope.search_user_name)
                url += '&s_user_name=' + $scope.search_user_name;

            if ($scope.search_languageslug)
                url += '&s_languageslug=' + $scope.search_languageslug;

            if ($scope.search_user_type)
                url += '&s_user_type=' + $scope.search_user_type;

            if ($scope.search_entity)
                url += '&s_entity=' + $scope.search_entity;

            if ($scope.search_updated_at)
                url += '&s_updated_at=' + $scope.search_updated_at;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }

        //Process_Type
        $http.get('/get_users/?page='+pageNumber+url).then(function(response) {
            $scope.users = response.data.data; //quando é procurado do processtypes para a linguagem
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



    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $http.get(API_URL + "/users/get_langs")
                    .then(function (response) {
                        $scope.langs = response.data;
                    });
                $http.get(API_URL + "/users/get_entities")
                    .then(function (response) {
                        $scope.entities = response.data;
                    });
                $scope.form_title = "Adding New User";
                $scope.btn_label = "Save";
                break;
            case 'edit':
                $scope.form_title = "Editing User";
                $scope.btn_label = "Save Edit";
                $scope.id = id;
                $http.get(API_URL + 'get_users/' + id)
                    .then(function(response) {
                        $scope.user = response.data;
                    });
                $http.get(API_URL + "/users/get_langs")
                    .then(function (response) {
                        $scope.langs = response.data;
                    });
                $http.get(API_URL + "/users/get_entities")
                    .then(function (response) {
                        $scope.entities = response.data;
                    });
                break;
            case 'remove':
                $scope.id = id;
                $scope.btn_label = "Remove User";
                $scope.form_title = "Removing User";
                $http.get(API_URL + 'get_users/' + id)
                    .then(function(response) {
                        $scope.user = response.data;
                    });
                $http.get(API_URL + "/users/get_langs")
                    .then(function (response) {
                        $scope.langs = response.data;
                    });
                $http.get(API_URL + "/users/get_entities")
                    .then(function (response) {
                        $scope.entities = response.data;
                    });
                break;
            case 'view_roles':
                $scope.id = id;
                $scope.btn_label = "Exit";
                $scope.form_title = "Roles of This User";
                $http.get(API_URL + 'get_users/' + id)
                    .then(function(response) {
                        $scope.user = response.data;
                    });
                $http.get(API_URL + '/users/get_selroles/' + id)
                    .then(function(response) {
                        $scope.selroles = response.data;
                    });
                break;

            case 'add_roles':
                $scope.id = id;
                $scope.btn_label = "Assign Roles to User";
                $scope.form_title = "Assigning Roles to User";
                $http.get(API_URL + 'get_users/' + id)
                    .then(function(response) {
                        $scope.user = response.data;
                    });
                $http.get(API_URL + '/users/get_roles')
                    .then(function(response) {
                        $scope.roles = response.data;
                    });
                $http.get(API_URL + '/users/get_selroles/' + id)
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

    $scope.removerole = function(userid, roleid) {
        var url = API_URL + "remove_user_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'user_id' : userid,
                    'role_id' : roleid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/users/get_selroles/' + userid)
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
        var url = API_URL + "users";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'remove') {
            url += "/remove/" + id;
        }


        if (modalstate === 'edit') {
            url += "/" + id;
        }

        if ($scope.user.user_type == "internal"){
            $scope.user.entities_id = null;
        }

        if(modalstate === 'add_roles') {

            url += "/update_roles/" + id;

            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'user_id' : $scope.user.id,
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
                    'user_id' : $scope.user.id,
                    'name': $scope.user.name,
                    'email': $scope.user.email,
                    'password': $scope.user.password,
                    'user_name': $scope.user.user_name,
                    'user_type': $scope.user.user_type,
                    'entity_id': $scope.user.entity_id,
                    'language_id': $scope.user.language_id,
                    // 'slug': $scope.language.slug,
                    // 'state': $scope.language.state,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getUsers();
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
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getUsers(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getUsers(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getUsers(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getUsers(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getUsers(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});

app.directive("passwordVerify", function() {
    return {
        require: "ngModel",
        scope: {
            passwordVerify: '='
        },
        link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;

                if (scope.passwordVerify || ctrl.$viewValue) {
                    combined = scope.passwordVerify + '_' + ctrl.$viewValue;
                }
                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
        }
    };
});