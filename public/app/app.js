/**
 * Created by ASUS on 26/05/2017.
 */
var app = angular.module('umaeeteam', ['angular-growl','smart-table','ui.sortable','pascalprecht.translate','ngTable','ui.bootstrap','ngAnimate'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})
    .constant('API_URL','http://localhost:8000/');

app.config(['growlProvider', function (growlProvider) {
    growlProvider.globalTimeToLive({success: 3000, error: 2000, warning: 3000, info: 4000});
}]);

app.service('MyService', function () {
    return {
        filter: function(params) {
            for (i=0; i<params.length; i++) {
                if (params[i])
                {
                    return true;
                }
            }
            return false;
        }
    };
});

app.config(function($translateProvider, $translatePartialLoaderProvider) {
    //$translateProvider.useMissingTranslationHandlerLog();
    /*$translateProvider.translations('en', {
        "Page_Name" : "Geweldige Whatsapp gesprekken.",
    });*/
    //$translatePartialLoaderProvider.addPart('main');
    $translateProvider.useLoader('$translatePartialLoader', {
        urlTemplate: 'translations/{lang}/{part}.json',
        loadFailureHandler: 'MyErrorHandler'
    });
    $translateProvider.preferredLanguage('en');
});

app.run(function ($rootScope, $translate) {
    $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
        $translate.refresh();
    });
});

app.factory('MyErrorHandler', function ($q, $log) {
    return function (part, lang, response) {
        $log.error('The "' + part + '/' + lang + '" part was not loaded.');
        return $q.when({});
    };
});

    app.filter('customFilter', function() {
    return function(items, props) {
        items.forEach(function(item) {

            console.log(JSON.stringify(item));
            item.language.forEach(function(item) {
                console.log(JSON.stringify(item.pivot.name));
            });
        });

        var out = [];
        /*console.log("items" + JSON.stringify(items));
        console.log("props" + JSON.stringify(props));
        var out = [];
        if (angular.isArray(items) && Object.keys(props).length > 0) {
            items.forEach(function(item) {
                console.log("o item escolhido " + JSON.stringify(item) + " tamanho=" + JSON.stringify(item.index));

                var itemMatches = false;
                var object = item;
                var keys = Object.keys(props);
                console.log("keys" + JSON.stringify(keys) + " tamanho=" + JSON.stringify(keys.length));
                var serchedAttr;
                for (var i = 0; i < keys.length; i++) {
                    var splits = keys[i].split('.'); //Split the attribut to and an array.
                    console.log("splits" + JSON.stringify(splits));
                    //We search the real object
                    splits.forEach(function (attr, index) {
                        console.log("object - " + JSON.stringify(object));
                        console.log("serchedAttr - " + JSON.stringify(attr));
                        if (index!= splits.length-1) {
                            object = object[attr];
                        }else {
                            serchedAttr = attr; //the attribute to filter
                        }
                    });
                    var prop = keys[i];
                    var text = props[keys[i]].toString().toLowerCase();
                    console.log("text " + JSON.stringify(prop));

                    if (object[serchedAttr].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }*/

        return out;
    }
});

app.directive('emitLastRepeaterElement', function() {
    return function(scope) {
        if (scope.$last){
            scope.$emit('LastRepeaterElement');
        }
    };
});

app.factory('Resource', ['$q', '$filter', '$timeout', '$http', function ($q, $filter, $timeout, $http) {

    var randomsItems = [];

    function getRandomsItems(cb) {
        return $http.get('/ents_types/get_ents_types', {cache: 'true'}).then(function(randomsItems) {
            cb(randomsItems.data);
        });
    }

    //fake call to the server, normally this service would serialize table state to send it to the server (with query parameters for example) and parse the response
    //in our case, it actually performs the logic which would happened in the server
    function getPage(start, number, params) {

        var result;
        var totalRows;

        getRandomsItems(function cb(randomsItems) {
            var filtered = params.search.predicateObject ? $filter('customFilter')(randomsItems, params.search.predicateObject) : randomsItems;
            console.log("Filtro:" + JSON.stringify(params.search.predicateObject));

            if (params.sort.predicate) {
                filtered = $filter('orderBy')(filtered, params.sort.predicate, params.sort.reverse);
            }

            result = filtered.slice(start, start + number);
            totalRows = randomsItems.length;

            /*console.log("Result : " + JSON.stringify(result));
            console.log("Total Rows : " + JSON.stringify(totalRows));*/
        });


        var deferred = $q.defer();

        $timeout(function () {

            deferred.resolve({
                data: result,
                numberOfPages: Math.ceil(totalRows / number)
            });

        }, 1500);

        return deferred.promise;

    }

    return {
        getPage: getPage
    };

}]);
