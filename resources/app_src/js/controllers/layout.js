angular.module('tdc').controller('LayoutController', [
    '$scope', '$rootScope', '$i18next',
    function($scope, $rootScope, $i18next) {


    $scope.languages = window.APP_DATA.languages;
    $rootScope.lng = window.APP_DATA.default_language;


    $scope.changeLanguage = function(lng) {
        $i18next.changeLanguage(lng);
        $rootScope.lng = lng;
        $rootScope.$broadcast('tdc.languageChange');
    }

}]);