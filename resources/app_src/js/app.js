require('angular')
require('angular-ui-router')
// todo: find better solution for angular-sanitize
angular.$$lowercase = function(str) {
    return str.toLowerCase();
}
require('angular-sanitize')
require('bootstrap/dist/css/bootstrap.css')
require('font-awesome/css/font-awesome.css')
require('../styles/styles.css')

window.$ = window.jQuery = require('jquery');



window.i18next = require('i18next');
require('ng-i18next');
var i18nextSprintf = require('i18next-sprintf-postprocessor');
window.i18next.use(i18nextSprintf);


var i18nextOpts = {
    lng: window.APP_DATA.default_language,
    fallbackLng: ['en'],
    fallbackNS: 'tdc',
    ns: ['tdc'],
    resources: {
        en: {
            tdc: require('../i18n/en.json')
        },
        fr: {
            tdc: require('../i18n/fr.json')
        }
    }

};

window.i18next.on('initialized', function (options) {
    i18next.options = options;
});
window.i18next.init(i18nextOpts);




var app = angular.module('tdc', [
    'jm.i18next', 'ui.router'
]).config(['$locationProvider', '$stateProvider', function($locationProvider, $stateProvider) {
    $locationProvider.html5Mode(true);

    $stateProvider
        .state('form', {
            url: '/',
            controller: 'FormController',
            templateUrl: require('../templates/form.html')
        })
        .state('certificate', {
            url: '/certificate/:first_name/:last_name/:code',
            controller: 'CertificateController',
            templateUrl: require('../templates/certificate.html')
        })
        .state('public_certificates', {
            url: '/public_certificates/:first_name/:last_name',
            controller: 'PublicCertificatesController',
            templateUrl: require('../templates/public_certificates.html')
        })

}]).filter('toDate', ['$filter', function($filter) {
    var angularDateFilter = $filter('date');
    return function(str) {
        var d = new Date(str);
        return angularDateFilter(d, window.APP_DATA.date_format);
    }
}])

require('./controllers/layout')
require('./controllers/form')
require('./controllers/certificate')
require('./controllers/public_certificates')
require('./directives/item')
require('../templates/layout.html')
require('../templates/spinner.html')
require('../templates/form.html')
require('../templates/certificate.html')
require('../templates/item.html')
require('../templates/public_certificates.html')