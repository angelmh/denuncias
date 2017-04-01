angular.module('starter', ['ionic','ngCordova','starter.controllers','starter.services'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

      cordova.plugins.Keyboard.disableScroll(true);

    

    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider){

 $ionicConfigProvider.tabs.position('bottom'); //bottom, top

$stateProvider
    

 .state('login', {
      url: '/login',
      templateUrl: 'templates/login.html',
      controller: 'LoginCtrl'

        
  })
    
    .state('tab', {
      url: '/tab',
      abstract: true,
      templateUrl: 'templates/tab.html'
    })



    .state('tab.home', {
      url: '/home',
      views: {
        'tab-home': {
          templateUrl: 'templates/home.html',
          controller: 'HomeController'
        }
      }
    })

    .state('tab.denunciar', {
      url: '/denunciar',
      views: {
        'tab-denunciar': {
          templateUrl: 'templates/denunciar.html',
          controller: 'DenunciarController'
        }
      }
    })

    .state('tab.denunciar2', {
      url: '/denunciar2',
      views: {
        'tab-denunciar2': {
          templateUrl: 'templates/denunciar2.html',
          controller: 'DenunciarController2'
        }
      }
    })

    .state('tab.comunidad', {
      url: '/comunidad',
      views: {
        'tab-comunidad': {
          templateUrl: 'templates/comunidad.html',
          controller: 'ComunidadController'
        }
      }
    })  
    
    .state('tab.reporte', {
      url: '/reporte/:id',
      views: {
        'tab-reporte': {
          templateUrl: 'templates/reporte.html',
          controller: 'ReporteController'
        }
      }
    })  

    .state('tab.datos', {
      url: '/datos',
      views: {
        'tab-datos': {
          templateUrl: 'templates/datos.html',
          controller: 'DatosController'
        }
      }
    })

    .state('tab.cerrar', {
      url: '/cerrar',
      views: {
        'cerrar': {
          controller: 'CerrarController'
        }
      }
    })

    .state('usuariotrabajador', {
      url: '/usuariotrabajador',
      abstract: true,
      templateUrl: 'templates/usuariotrabajador/tab.html'
    })

    .state('usuariotrabajador.reportes', {
      url: '/usuariotrabajador.reportes',
      views: {
        'usuariotrabajador.reportes': {
          templateUrl: 'templates/usuariotrabajador/reportes.html',
          controller: 'TrabajadorReportesController'
        }
      }
    })
    
    .state('usuariotrabajador.comunidad', {
      url: '/comunidad',
      views: {
        'usuariotrabajador.comunidad': {
          templateUrl: 'templates/usuariotrabajador/comunidad.html',
          controller: 'TrabajadorComunidadController'
        }
      }
    })  
    
    .state('usuariotrabajador.reporte', {
      url: '/reporte/:id',
      views: {
        'usuariotrabajador.reporte': {
          templateUrl: 'templates/usuariotrabajador/reporte.html',
          controller: 'TrabajadorReporteController'
        }
      }
    }) 

    .state('usuariotrabajador.recientes', {
      url: '/recientes', 
      views: {
              'usuariotrabajador.recientes': 
                  { 
                    templateUrl: 'templates/usuariotrabajador/recientes.html',
                    controller: 'TrabajadorRecientesController'
                    }
            }
    }) 

    .state('usuariotrabajador.votacion', {
      url: '/votacion',
      views: {
        'usuariotrabajador.votacion': {
          templateUrl: 'templates/usuariotrabajador/votacion.html',
          controller: 'TrabajadorVotacionController'
        }
      }
    })

     .state('usuariotrabajador.datos', {
      url: '/datos',
      views: {
        'usuariotrabajador.datos': {
          templateUrl: 'templates/usuariotrabajador/datos.html',
          controller: 'TrabajadorDatosController'
        }
      }
    })

    $urlRouterProvider.otherwise('/login');
})

