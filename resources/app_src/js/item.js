angular.module('tdc').directive('item', function () {
    return {
        templateUrl: require('../templates/item.html'),
        restrict: 'E',
        scope: {
            data: '='
        },
        controller: ['$scope', function ($scope) {

            function translate(lng) {
                $scope.name = $scope.data.translations[lng].name;
                $scope.description = $scope.data.translations[lng].description;
            }

            translate(window.APP_DATA.default_language);

            $scope.$on('tdc.languageChange', function(e, lng) {
                translate(lng);
            })

        }]
    }
});
