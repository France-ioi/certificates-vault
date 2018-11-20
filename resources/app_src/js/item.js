angular.module('tdc').directive('item', function () {
    return {
        templateUrl: require('../templates/item.html'),
        restrict: 'E',
        scope: {
            data: '='
        },
        controller: ['$scope', function ($scope) {

            $scope.trophy_icon = false;

            if($scope.data.children && $scope.data.type == 'SKILL') {
                for(var i=0; i<$scope.data.children.length; i++) {
                    var item = $scope.data.children[i];
                    if(item.type == 'ACTIVITY' && item.on_site) {
                        $scope.trophy_icon = true;
                        break;
                    }
                }
            }



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
