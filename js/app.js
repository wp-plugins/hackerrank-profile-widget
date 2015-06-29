/*
 * HackerRank Profile Widget for WordPress
 *
 *     Copyright (C) 2015 Henrique Dias <hacdias@gmail.com>
 *     Copyright (C) 2015 Luís Soares <lsoares@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

(function (angular) {

    angular.element(document).ready(function () {
        var widgets = document.getElementsByClassName("hackerrank-widget");

        for (var i = widgets.length - 1; i >= 0; i--) {
            angular.bootstrap(widgets[i], ["hackerRankWidgetApp"]);
        }
    });

    var app = angular.module('hackerRankWidgetApp', []);

    app.controller("GenericHackerRankController", function ($scope, $http, $attrs, $element, $log) {

        var widget = jQuery($element).parents('.hackerrank-widget'); // TODO .... remove... devia ser com vars angularjs
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
            console.log(requests + $attrs.method, {params: qsParams});
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
