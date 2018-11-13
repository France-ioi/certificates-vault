angular.module('tdc').directive('item', function () {
    return {
        templateUrl: require('../templates/item.html'),
        restrict: 'E',
        scope: {
            data: '='
        },
        controller: ['$scope', function ($scope) {
            $scope.name = $scope.data.translations['EN'].name;
            $scope.description = $scope.data.translations['EN'].description;
        }]
    }
});
