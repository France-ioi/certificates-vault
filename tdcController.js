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

// from http://stackoverflow.com/questions/979975/
var QueryString = function () {
  // This function is anonymous, is executed immediately and
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
        // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
        // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
      query_string[pair[0]] = arr;
        // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  }
  return query_string;
}();


var app = angular.module('tdc', ['jm.i18next']);

app.controller('tdcController', ['$scope', '$http', '$timeout', '$i18next', function($scope, $http, $timeout, $i18next) {
    $scope.curTemplate = 'templates/verification.html';
    $scope.params = {};

    $scope.getCertificate = function() {
        var params = Object.assign({}, $scope.params);
        params.action = 'getCertificate';
        $http.post('data.php', params, {responseType: 'json'}).then(function(res) {
            if(res.data.success) {
                $scope.data = res.data.data;
                $scope.curTemplate = 'templates/viewCertificate.html';
            } else {
                $scope.invalid = true;
            }
            }, function(res) {
                // HTTP query failed, show an error
            });
    };
}]);
