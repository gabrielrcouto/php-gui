(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').controller(
    'HomeController',
    function HomeController(HomeResolve) {
      var _self = this;

      _self.home = HomeResolve;
    }
  );

})();
