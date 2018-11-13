angular.module('tdc').controller('tdcController', ['$scope', '$http', '$location', '$i18next', function($scope, $http, $location, $i18next) {

    $scope.error = false;

    function showCertificate(state) {
        $scope.params = state.params;
        $scope.data = state.data;
        $scope.curTemplate = require('../templates/certificate.html');
    }

    function showForm() {
        $scope.params = {
            first_name: '', //'user_first_name',
            last_name: '',//'user_last_name',
            code: ''//'dJrrYYaz'
        };
        $scope.data = null;
        $scope.curTemplate = require('../templates/verification.html');
    }

    if(window.__APP_STATE) {
        showCertificate(window.__APP_STATE);
    } else {
        showForm();
    }


    $scope.$on('$locationChangeStart', function(e, new_url, old_url){
        if(new_url == old_url) return;
        var state = $location.state();
        if(state && state.data) {
            $scope.data = state.data;
            $scope.params = state.params;
            $scope.curTemplate = require('../templates/certificate.html');
        } else {
            showForm();
        }
    });




    $scope.getQRCodeUrl = function() {
        return '/qrcode?url=' + encodeURIComponent(location.href)
    }

    $scope.getCertificate = function() {
        var url_path =
            encodeURIComponent($scope.params.first_name) + '/' +
            encodeURIComponent($scope.params.last_name) + '/' +
            encodeURIComponent($scope.params.code);
        $http.get('/certificates/' + url_path, {responseType: 'json'}).then(function(res) {
            if(res && res.data.success) {
                var state = {
                    params: Object.assign({}, $scope.params),
                    data: res.data.data
                }
                showCertificate(state);
                $location.path('/certificate/' + url_path).state(state);
            } else {
                $scope.error = true;
            }
        }, function(res) {
                $scope.error = true;
        });
    };


    $scope.resetError = function() {
        $scope.error = false;
    }
}]);
