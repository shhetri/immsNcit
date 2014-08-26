/**
 * Created by SHhetri on 8/23/14.
 */
"use strict";
var app = angular.module('app', ['ngSanitize']);

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