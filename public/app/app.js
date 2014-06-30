"use strict";
var app = angular.module('app', ['ngSanitize', 'ui.select']);

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

    $scope.loadPage();
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

    $scope.loadPage();
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

    $scope.loadPage();
});

app.service('subjectService', function ($http) {
    this.getSubjects = function (main) {
        return $http.get('/all/subjects?page=' + main.page);
    };
});

app.controller('SubjectAssignedToController', function ($rootScope, $scope, subjectAssignedToService) {
    $scope.loadPage = function () {
        // You could use Restangular here with a route resource.
        subjectAssignedToService.getTeachers($rootScope.main, $scope.id).success(function (result) {
            // users from your api
            $scope.main.info = result.data;

            // number of pages of users
            $rootScope.main.pages = result.last_page;
            $scope.main.total = result.total;
        });
    };

    $scope.$watch('id', function () {
        $scope.loadPage();
    });

});

app.service('subjectAssignedToService', function ($http) {
    this.getTeachers = function (main, id) {
        return $http.get('/subjects/' + id + '/assigned/info?page=' + main.page);
    };
});

app.controller('StudentController', function ($scope, studentService) {

    $scope.faculty = {};
    $scope.shift = {};
    $scope.batch = {};
    $scope.main.students = [];
    studentService.getFacultyShiftAndBatch().success(function (result) {
        $scope.info = result;
        $scope.faculty.selected = $scope.info.faculty[0];
        $scope.shift.selected = $scope.info.shift[0];
        $scope.batch.selected = $scope.info.batch[0];
    });

    $scope.getStudents = function () {
        $scope.viewLoading = true;
        studentService.getStudents($scope.faculty.selected.id, $scope.shift.selected.id, $scope.batch.selected.id).success(function (result) {
            $scope.main.students = result;
            $scope.main.noStudents = $scope.main.students.length == 0;
            $scope.viewLoading = false;
        });
    }
});

app.service('studentService', function ($http) {
    this.getFacultyShiftAndBatch = function () {
        return $http.get('all/faculty/shift/batch');
    };

    this.getStudents = function (faculty, shift, batch) {
        return $http.get('all/students/' + faculty + '/' + shift + '/' + batch);
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

app.config(function (uiSelectConfig) {
    uiSelectConfig.theme = 'bootstrap';
});

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
                lines: 11, // The number of lines to draw
                length: 27, // The length of each line
                width: 8, // The line thickness
                radius: 1, // The radius of the inner circle
                corners: 0.7, // Corner roundness (0..1)
                rotate: 11, // The rotation offset
                direction: 1, // 1: clockwise, -1: counterclockwise
                color: '#BCBCBC', // #rgb or #rrggbb or array of colors
                speed: 1, // Rounds per second
                trail: 90, // Afterglow percentage
                shadow: false, // Whether to render a shadow
                hwaccel: false, // Whether to use hardware acceleration
                className: 'spinner', // The CSS class to assign to the spinner
                zIndex: 2e9, // The z-index (defaults to 2000000000)
                top: '200%', // Top position relative to parent
                left: '50%' // Left position relative to parent
            };
            var spinner = new Spinner(opts).spin();
            var loadingContainer = element.find('.my-loading-spinner-container')[0];
            loadingContainer.appendChild(spinner.el);
        }
    };
});