(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').controller(
    'BaseController',
    function BaseController(VersionsResolve, $http) {
      var _self = this;

      _self.versions = VersionsResolve;
      _self.currentVersion = 
      _self.classes = [];


      for (var i = 0; i < _self.versions.length; i++) {
        if (_self.versions[i].stable) {
          _self.currentVersion = _self.versions[i];
          $http.get('assets/markdown/' + _self.versions[i].version + '/map.json').then(function (response) {
            for (var j = 0; j < response.data.length; j++) {
                _self.classes.push({
                    version: _self.currentVersion.version,
                    path: response.data[j].fileName,
                    label: response.data[j].label
                });
            }
          });
        }
      }

    }
  );

})();
