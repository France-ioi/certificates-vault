require('angular')
// todo: find better solution for angular-sanitize
angular.$$lowercase = function(str) {
    return str.toLowerCase();
}
require('angular-sanitize')
require('bootstrap/dist/css/bootstrap.css')
require('font-awesome/css/font-awesome.css')
require('./styles/styles.css')



var app = angular.module('tdc', [
    //'ngSanitize',
    'jm.i18next'
]).config(['$locationProvider', function($locationProvider) {
    $locationProvider.html5Mode(true);
}]);

require('./js/controller')
require('./js/item')
require('./templates/verification.html')
require('./templates/certificate.html')
require('./templates/item.html')


window.$ = window.jQuery = require('jquery');
window.i18next = require('i18next');
window.i18nextXHRBackend = require('i18next-xhr-backend');
require('ng-i18next');
window.i18next.use(window.i18nextXHRBackend);

var i18nextOpts = {
    lng: 'en',
    fallbackLng: ['en', 'fr'],
    fallbackNS: 'tdc',
    ns: ['tdc'],
  };
i18nextOpts['backend'] = {
    'allowMultiLoading': false,
    'loadPath': function (lng, ns) {
        return 'i18n/'+lng+'/'+ns+'.json';
    }
};
window.i18next.init(i18nextOpts);
window.i18next.on('initialized', function (options) {
    window.i18nextOptions = options;
});