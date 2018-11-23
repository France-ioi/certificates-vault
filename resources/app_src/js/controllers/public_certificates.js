angular.module('tdc').controller('PublicCertificatesController', [
    '$scope', '$rootScope', '$http', '$stateParams', '$state',
    function($scope, $rootScope, $http, $stateParams, $state) {


        $rootScope.latest_version_url = false;
        $rootScope.public_certificates_url = false;

        $scope.loading = false;
        $scope.data = null;

        var data = null;
        function translate() {
            $scope.data = [];
            for(var i=0; i<data.length; i++) {
                $scope.data[i] = {
                    name: data[i].translations[$rootScope.lng].name,
                    created_at: data[i].created_at,
                    url: $state.href('certificate', {
                        first_name: $stateParams.first_name,
                        last_name: $stateParams.last_name,
                        code: data[i].code
                    })
                }
            }
        }

        $scope.$on('tdc.languageChange', function(e) {
            translate();
        })


        var url = '/api/public_certificates/' +
            encodeURIComponent($stateParams.first_name) + '/' +
            encodeURIComponent($stateParams.last_name);
        $http.get(url, {responseType: 'json'}).then(function(res) {
            $scope.loading = false;
            if(res && res.data.success) {
                data = res.data.data;
                translate();
            } else {
                $scope.error = true;
            }
        }, function(res) {
            $scope.loading = false;
            $scope.error = true;
        });


    }
]);