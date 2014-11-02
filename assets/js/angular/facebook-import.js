var app = angular.module('myApp', ['ui.bootstrap', 'ngQuickDate', 'toaster']);

app.config(function(ngQuickDateDefaultsProvider) {
    // Configure with icons from font-awesome
    return ngQuickDateDefaultsProvider.set({
        closeButtonHtml: " <i class='fa fa-times'></i> ",
        buttonIconHtml: " <i class='fa fa-calendar'></i> ",
        nextLinkHtml: " <i class='fa fa-chevron-right'></i> ",
        prevLinkHtml: " <i class='fa fa-chevron-left'></i> ",
    });
}).controller('myController', function( $scope, $sce, $http, $filter, toaster ) {
    $scope.retrievePosts = function( accessToken ) {
        $scope.loading = true;
        $http({
            'method': 'GET',
            'url': '/api/tools/fetch_messages?token=' + accessToken
        }).success(function(data, status, headers, config) {
            toaster.pop('success', 'Success: ' + status, "Retrieved posts. Sort away!");
            $scope.postings = data;
            $scope.loading = false;

        }).error(function(data, status, headers, config) {
            toaster.pop('error', 'Error: ' + status, data.message);
            $scope.loading = false;
        });
    };

    $scope.forgetRide = function(posting, key) {
        var r = confirm("This facebook posting will never show again, ok?");
        if ( r == true ) {
            $scope.loading = true;
            $http({
                'method': 'POST',
                'url': '/api/tools/forget_ride',
                'data': {
                    'posting': posting
                }
            }).success(function(data, status, headers, config) {
                toaster.pop('success', 'Success: ' + status, data.message);
                $scope.postings.splice(key, 1);
                $scope.loading = false;

            }).error(function(data, status, headers, config) {
                toaster.pop('error', 'Error: ' + status, data.message);
                $scope.loading = false;
            });
        } else {
            return;
        }
    };

    $scope.importRide = function(posting, key) {
        var r = confirm("Import this ride according to input details?");
        if ( r == true ) {
            $scope.loading = true;
            $http({
                'method': 'POST',
                'url': '/api/tools/import_ride',
                'data': {
                    'posting': posting
                }
            }).success(function(data, status, headers, config) {
                toaster.pop('success', 'Success: ' + status, data.message);
                console.log(data);
                $scope.postings.splice(key, 1);
                $scope.loading = false;

            }).error(function(data, status, headers, config) {
                toaster.pop('error', 'Error: ' + status, data.message);
                $scope.loading = false;
            });
        } else {
            return;
        }
    };

    $scope.Date = function(arg) {
        if ( arg ) {
            return new Date( arg );
        } else {
            return new Date();
        }
    };

}).filter('facebookImage', function() {
    return function(facebookId) {
        return '//graph.facebook.com/' + facebookId + '/picture?width=40&height=40';
    };
}).filter('facebookPostLink', function() {
    return function(facebookPostId) {
        return '//facebook.com/' + facebookPostId;
    };
}).directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function(val) {
                var clean = val.replace( /[^0-9]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
});