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

//var xhReq = new XMLHttpRequest();
//xhReq.open("GET", "/token", false);
//xhReq.send(null);
//
//angular.module('app').constant("CSRF_TOKEN", xhReq.responseText);
configure.inject = ['$interpolateProvider'];

function configure($interpolateProvider) {
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
}