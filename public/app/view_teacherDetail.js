"use strict";
var app = angular.module('app', ['ngSanitize']);

app.run(function ($rootScope) {
    $rootScope.main = {
        page: 1
    };

    $rootScope.nextPage = function ($scope) {
        if ($rootScope.main.page < $rootScope.main.pages) {
            $rootScope.main.page++;
            $scope.loadPage();
        }
    };

    $rootScope.previousPage = function ($scope) {
        if ($rootScope.main.page > 1) {
            $rootScope.main.page--;
            $scope.loadPage();
        }
    };
});

app.controller('ViewController', function ($rootScope, $scope, viewService) {

    $scope.activeValue;
    $scope.loadPage = function () {
        // You could use Restangular here with a route resource.
        viewService.getTeachers($rootScope.main).success(function (result) {
            // users from your api
            $scope.main.teachers = result.data;

            // number of pages of users
            $rootScope.main.pages = result.last_page;
            $scope.main.total = result.total;
        });
    };

    $scope.getDetail = function (teacherId) {
        $scope.viewLoading = true;
        $scope.activeValue = teacherId;
        viewService.getTeacherDetail(teacherId).success(function (result) {
            $scope.main.teacherDetail = result;
            $scope.viewLoading = false;
        });
    };

    $scope.loadPage();
});

app.service('viewService', function ($http) {
    this.getTeachers = function (main) {
        return $http.get('/view/teachers/all?page=' + main.page);
    };

    this.getTeacherDetail = function (teacherId) {
        return $http.get('/view/teacherDetail/' + teacherId);
    }
});

app.filter('capitalize', function () {
    return function (input, scope) {
        if (input != null)
            input = input.toLowerCase();
        return input.substring(0, 1).toUpperCase() + input.substring(1);
    }
});

app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);

app.directive('myLoadingSpinner', function () {
    return {
        restrict: 'A',
        replace: true,
        transclude: true,
        scope: {
            loading: '=myLoadingSpinner'
        },
        templateUrl: 'loading/spinner',
        link: function (scope, element, attrs) {
            var opts = {
                lines: 9, // The number of lines to draw
                length: 22, // The length of each line
                width: 6, // The line thickness
                radius: 0, // The radius of the inner circle
                corners: 1.0, // Corner roundness (0..1)
                rotate: 0, // The rotation offset
                direction: 1, // 1: clockwise, -1: counterclockwise
                color: '#000', // #rgb or #rrggbb or array of colors
                speed: 1.2, // Rounds per second
                trail: 60, // Afterglow percentage
                shadow: false, // Whether to render a shadow
                hwaccel: false, // Whether to use hardware acceleration
                className: 'spinner', // The CSS class to assign to the spinner
                zIndex: 2e9, // The z-index (defaults to 2000000000)
                top: '15000%', // Top position relative to parent
                left: '65%' // Left position relative to parent
            };
            var spinner = new Spinner(opts).spin();
            var loadingContainer = element.find('.my-loading-spinner-container')[0];
            loadingContainer.appendChild(spinner.el);
        }
    };
});