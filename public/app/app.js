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

configure.inject = ['$interpolateProvider','$locationProvider'];

function configure($interpolateProvider,$locationProvider) {
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
    $locationProvider.html5Mode({enabled: true,requireBase: false});
}