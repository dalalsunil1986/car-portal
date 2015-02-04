angular
    .module('app', [
        'ngAnimate',
        'ngSanitize',
        'ui.select',
        'infinite-scroll',
        'ngResource'
    ]);

//set the angular tags to {[ ]} to avoid conflict with laravel blade tags
angular
    .module('app')
    .config(configure);

configure.inject = ['$interpolateProvider'];

function configure($interpolateProvider) {
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
}