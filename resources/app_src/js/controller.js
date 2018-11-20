angular.module('tdc').controller('tdcController', ['$scope', '$rootScope', '$http', '$location', '$i18next', function($scope, $rootScope, $http, $location, $i18next) {

    function certPath(user, code) {
        return encodeURIComponent(user.first_name) + '/' +
        encodeURIComponent(user.last_name) + '/' +
        encodeURIComponent(code);
    }

    $scope.lng = window.APP_DATA.default_language;

    $scope.$on('tdc.languageChange', function(e, lng) {
        $scope.lng = lng;
        translate();
    })

    $scope.layout_tpl = require('../templates/layout.html');
    $scope.error = false;
    $scope.site_url = window.location.origin;


    function translate() {
        if(!$scope.data) return;
        $scope.strings = $scope.data.translations[$scope.lng];
    }


    function showCertificate(state) {
        $scope.params = state.params;
        $scope.data = state.data;
        $scope.curTemplate = require('../templates/certificate.html');
        translate();

        if(state.data.latest_version_code) {
            $rootScope.latest_version_path = '/certificate/' +
                certPath(state.params, state.data.latest_version_code);
        } else {
            $rootScope.latest_version_path = false;
        }
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

    if(window.APP_STATE) {
        showCertificate(window.APP_STATE);
    } else {
        showForm();
    }


    $scope.$on('tdc.languageChange', function(e, lng) {
        translate(lng);
    })


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
        var url_path = certPath($scope.params, $scope.params.code);

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
