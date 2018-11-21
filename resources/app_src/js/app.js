require('angular')
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
    'jm.i18next'
]).config(['$locationProvider', function($locationProvider) {
    $locationProvider.html5Mode(true);
}]).filter('toDate', ['$filter', function($filter) {
    var angularDateFilter = $filter('date');
    return function(str) {
        var d = new Date(str);
        return angularDateFilter(d, window.APP_DATA.date_format);
    }
}]);


require('./controllers/controller')
require('./controllers/layout')
require('./controllers/language_select')
require('./directives/item')
require('../templates/layout.html')
require('../templates/verification.html')
require('../templates/certificate.html')
require('../templates/item.html')