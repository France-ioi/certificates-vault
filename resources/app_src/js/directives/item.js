angular.module('tdc').directive('item', function() {
    return {
        templateUrl: require('../../templates/item.html'),
        restrict: 'E',
        scope: {
            data: '='
        },
        controller: ['$i18next', '$scope', '$filter', function ($i18next, $scope, $filter) {

            $scope.root = !!$scope.data.children;
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
                if($scope.root) {
                    $scope.name = $scope.data.translations[lng].name;
                } else {
                    var key = $scope.data.on_site ? 'cert_subitem_name_on_site' : 'cert_subitem_name';
                    var values = [
                        $scope.data.completion_rate,
                        $scope.data.translations[lng].name,
                        $filter('toDate')($scope.data.date)
                    ];
                    $scope.name = $i18next.t(key, { postProcess: 'sprintf', sprintf: values });
                }
                $scope.description = $scope.data.translations[lng].description;
            }
            translate(window.APP_DATA.default_language);

            $scope.$on('tdc.languageChange', function(e, lng) {
                translate(lng);
            })


            $scope.expanded = false;
            $scope.toggleDescription = function() {
                $scope.expanded = !$scope.expanded;
            }

        }]
    }
});