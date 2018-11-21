angular.module('tdc').controller('languageSelectController', ['$scope', '$rootScope', '$i18next', function($scope, $rootScope, $i18next) {

    $scope.languages = window.APP_DATA.languages;
    $scope.lng = window.APP_DATA.default_language;


    $scope.refresh = function(lng) {
        $i18next.changeLanguage(lng);
        $rootScope.$broadcast('tdc.languageChange', lng);
    }

}]);