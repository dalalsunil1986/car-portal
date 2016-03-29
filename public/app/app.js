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

configure.inject = ['$interpolateProvider', '$httpProvider', '$locationProvider', '$compileProvider'];

function configure($interpolateProvider, $httpProvider, $locationProvider, $compileProvider) {
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
    $httpProvider.useApplyAsync(true);
    //$compileProvider.debugInfoEnabled(false);
    //$locationProvider.html5Mode({enabled: true,requireBase: false});
}