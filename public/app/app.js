"use strict";
var app = angular.module('app', []);

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

app.controller('TeacherController', function ($rootScope, $scope, teacherService) {

    $scope.loadPage = function () {
        // You could use Restangular here with a route resource.
        teacherService.getTeachers($rootScope.main).success(function (result) {
            // users from your api
            $scope.main.teachers = result.data;

            // number of pages of users
            $rootScope.main.pages = result.last_page;
            $scope.main.total = result.total;
        });
    };
});

app.service('teacherService', function ($http) {
    this.getTeachers = function (main) {
        return $http.get('/all/teachers?page=' + main.page);
    };
});

app.controller('ClassController', function ($rootScope, $scope, classService) {

    $scope.loadPage = function () {
        // You could use Restangular here with a route resource.
        classService.getClasses($rootScope.main).success(function (result) {
            // users from your api
            $scope.main.classes = result.data;

            // number of pages of users
            $rootScope.main.pages = result.last_page;
            $scope.main.total = result.total;
        });
    };
});

app.service('classService', function ($http) {
    this.getClasses = function (main) {
        return $http.get('/all/classes?page=' + main.page);
    };
});

app.controller('SubjectController', function ($rootScope, $scope, subjectService) {

    $scope.loadPage = function () {
        // You could use Restangular here with a route resource.
        subjectService.getSubjects($rootScope.main).success(function (result) {
            // users from your api
            $scope.main.subjects = result.data;

            // number of pages of users
            $rootScope.main.pages = result.last_page;
            $scope.main.total = result.total;
        });
    };
});

app.service('subjectService', function ($http) {
    this.getSubjects = function (main) {
        return $http.get('/all/subjects?page=' + main.page);
    };
});

app.filter('capitalize', function () {
    return function (input, scope) {
        if (input != null)
            input = input.toLowerCase();
        return input.substring(0, 1).toUpperCase() + input.substring(1);
    }
});