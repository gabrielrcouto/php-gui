(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').config(
    function config(ngProgressProvider) {
      // ngProgress Configuration
      ngProgressProvider.setColor('#9C9C9C');
      ngProgressProvider.setHeight('4px');
    }
  );

})();
