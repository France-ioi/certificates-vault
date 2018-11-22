angular.module('tdc').controller('CertificateController', [
    '$scope', '$rootScope', '$http', '$stateParams', '$state',
    function($scope, $rootScope, $http, $stateParams, $state) {

        $scope.site_url = window.location.origin;
        $scope.error = false;
        $scope.loading = true;
        $scope.data = null;

        var url = '/api/certificate/' +
            encodeURIComponent($stateParams.first_name) + '/' +
            encodeURIComponent($stateParams.last_name) + '/' +
            encodeURIComponent($stateParams.code);
        $http.get(url, {responseType: 'json'}).then(function(res) {
            $scope.loading = false;
            if(res && res.data.success) {
                showCertificate(res.data.data);
            } else {
                $scope.error = true;
            }
        }, function(res) {
            $scope.loading = false;
            $scope.error = true;
        });


        function translate() {
            if(!$scope.data) return;
            $scope.strings = $scope.data.translations[$scope.lng];
        }


        function showCertificate(data) {
            $scope.params = $stateParams;
            $scope.data = data;
            translate();

            if(data.latest_version_code) {
                $rootScope.latest_version_url = $state.href('certificate', {
                    first_name: $stateParams.first_name,
                    last_name: $stateParams.last_name,
                    code: data.latest_version_code
                });
            } else {
                $rootScope.latest_version_url = false;
            }

            if(data.public_list_available) {
                $rootScope.public_certificates_url = $state.href('public_certificates', {
                    first_name: $stateParams.first_name,
                    last_name: $stateParams.last_name
                });
            } else {
                $rootScope.public_certificates_url = false;
            }
        }


        $scope.$on('tdc.languageChange', function(e) {
            translate();
        })
    }
]);