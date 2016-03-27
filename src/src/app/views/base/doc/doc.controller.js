(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').controller(
    'DocController',
    function DocController(DocResolve) {
      var _self = this;

      _self.doc = DocResolve;
    }
  );

})();
