angular
    .module('app', [
        'ngAnimate',
        'ngSanitize',
        'ui.select',
        'infinite-scroll',
        'ngResource',
        'ui.bootstrap'
    ]);

//set the angular tags to {[ ]} to avoid conflict with laravel blade tags
angular
    .module('app')
    .config(configure);

configure.inject = ['$interpolateProvider', '$locationProvider', '$httpProvider', '$compileProvider'];

function configure($interpolateProvider, $locationProvider, $httpProvider, $compileProvider) {
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
    $httpProvider.useApplyAsync(true);
    //$compileProvider.debugInfoEnabled(false);
    //$locationProvider.html5Mode({enabled: true,requireBase: false});
}