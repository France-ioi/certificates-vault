angular.module('tdc').controller('FormController', [
    '$scope', '$rootScope', '$http', '$location', '$i18next',
    function($scope, $rootScope, $http, $location, $i18next) {

        $scope.platform_url = window.APP_DATA.platform_url;

        $scope.params = {
            first_name: 'user_first_name',
            last_name: 'user_last_name',
            code: '968573849'
        };



        $scope.getCertificate = function() {
            var path = '/certificate/' +
                encodeURIComponent($scope.params.first_name) + '/' +
                encodeURIComponent($scope.params.last_name) + '/' +
                encodeURIComponent($scope.params.code);
            $location.path(path);
        };

}]);