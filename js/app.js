(function (angular) {

    angular.element(document).ready(function () {
        var widgets = document.getElementsByClassName("hackerRankWidget");

        for (var i = widgets.length - 1; i >= 0; i--) {
            angular.bootstrap(widgets[i], ["hackerRankWidgetApp"]);
        }
    });

    var app = angular.module('hackerRankWidgetApp', []);

    app.controller("GenericHackerRankController", function ($scope, $http, $attrs, $element, $log) {

        var widget = jQuery($element).parents('.hackerRankWidget'); // TODO .... remove... devia ser com vars angularjs
        var requests = widget.data('requestsurl');   // TODO .... remove... devia ser com vars angularjs

        $scope.baseUrl = 'https://www.hackerrank.com';

        if (!$attrs.ignoreoffset) {
            $scope.limit = 5;
            $scope.offset = 0;
        }

        $scope.currentPage = 1;

        function handleResponse(data, status, headers, config) {
            $log.info($attrs.method, data);
            $scope.data = data;
            if ($attrs.method == 'scores2') {
                $scope.data.medals = {gold: 0, silver: 0, bronze: 0};
                $scope.data.medalsUrl = 'https://www.hackerrank.com/assets/badges/';
                angular.forEach($scope.data, function (value, key) {
                    if (value.contest.medals) {
                        $scope.data.medals.gold += value.contest.medals.gold;
                        $scope.data.medals.silver += value.contest.medals.silver;
                        $scope.data.medals.bronze += value.contest.medals.bronze;
                    }
                });
            }

            if (!$attrs.ignoreoffset) {
                $scope.setButtonsState = function () {
                    $scope.thereIsPrevious = $scope.previousPageExists();
                    $scope.thereIsNext = $scope.nextPageExists();
                };

                $scope.setButtonsState();
            }
        }

        $scope.$watch('offset', function () {
            var qsParams = {offset: $scope.offset, limit: $scope.limit};
            $http.get(requests + $attrs.method, {params: qsParams}).success(handleResponse);
        });

        if (!$attrs.ignoreoffset) {

            $scope.previousPageExists = function () {
                return $scope.currentPage > 1;
            };

            $scope.nextPageExists = function () {
                return $scope.data.models.length == $scope.limit &&
                    $scope.currentPage >= 1;
            };

            $scope.previousPage = function () {
                if ($scope.previousPageExists()) {
                    $scope.offset -= $scope.limit;
                    $scope.currentPage--;
                }
            };

            $scope.nextPage = function () {
                if ($scope.nextPageExists()) {
                    $scope.offset += $scope.limit;
                    $scope.currentPage++;
                }
            };
        }
    });

})(window.angular);
