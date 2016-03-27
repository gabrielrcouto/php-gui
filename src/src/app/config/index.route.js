(function() {
  'use strict';

  /** @ngInject */
  angular.module('app').config(
    function routerConfig($stateProvider, $urlRouterProvider) {

      /** @ngInject */
      var HomeResolve = function (MarkdownService) {
        return MarkdownService.getMd('https://raw.githubusercontent.com/gabrielrcouto/php-gui/master/README.md').then(function (data) {
          return data;
        });
      };

      /** @ngInject */
      var VersionsResolve = function ($http) {
        return $http.get('assets/versions.json').then(function (response) {
          return response.data;
        });
      };

      /** @ngInject */
      var DocResolve = function ($stateParams, MarkdownService) {
        return MarkdownService.getAssetsMd($stateParams.version + '/' + $stateParams.path).then(function (data) {
          return data;
        });
      };

      var states = [
        {
          stateName: 'root',
          stateData: {
            abstract: true,
            templateUrl: 'app/views/base/base.html',
            controller: 'BaseController',
            controllerAs: 'controller',
            resolve: {
              'VersionsResolve': VersionsResolve
            }
          }
        },
        {
          stateName: 'root.home',
          stateData: {
            url: '/home',
            views: {
              'content': {
                templateUrl: 'app/views/base/home/home.html',
                controller: 'HomeController',
                controllerAs: 'controller',
                resolve: {
                  'HomeResolve': HomeResolve
                }
              }
            }
          }
        },
        {
          stateName: 'root.doc',
          stateData: {
            url: '/:version/:path',
            views: {
              'content': {
                templateUrl: 'app/views/base/doc/doc.html',
                controller: 'DocController',
                controllerAs: 'controller',
                resolve: {
                  'DocResolve': DocResolve
                }
              }
            }
          }
        },

      ];

      angular.forEach (states, function (state) {
        $stateProvider.state(state.stateName, state.stateData);
      });

      $urlRouterProvider.otherwise('/home');
    }
  );

})();