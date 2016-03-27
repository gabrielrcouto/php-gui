(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').run(
    function run($rootScope, ngProgress) {
      $rootScope.$on('$stateChangeStart', function () {
        ngProgress.start();
      });

      $rootScope.$on('$stateChangeSuccess', function () {
        ngProgress.complete();
      });
    }
  );

})();
