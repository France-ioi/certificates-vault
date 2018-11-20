angular.module('tdc').controller('layoutController', ['$scope', function($scope) {

    $scope.$on('tdc.certLoaded', function(e, data) {
        $scope.latest_version_url = data.latest_version_path;
        console.log(data)
    })

}]);