(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').service(
    'MarkdownService',
    function MarkdownService($q, $http) {
      var _self = this;

      _self.getMd = function (md) {
        return $http.get(md).then(function (response) {
          return response.data;
        });
      };

      _self.getAssetsMd = function (md) {
        return $http.get('assets/markdown/' + md).then(function (response) {
          return response.data;
        });
      };
    }
  );

})();
