angular.module('app').directive('carResults', function () {
    return {
        restrict: "A",
        templateUrl: '/app/views/cars/result.html'
    }
});

angular.module('app').directive('priceSlider', function () {
    return {
        restrict: 'A',
        link: function (scope, element) {
            var moved = false;
            var from = scope.priceFrom;
            var to = scope.priceTo;
            element.ionRangeSlider({
                min: 500,
                max: 50000,
                from: from,
                to: to,
                type: 'double',
                step: 200,
                postfix: " KD",
                maxPostfix: "+",
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    scope.priceFrom = obj.fromNumber;
                    scope.priceTo = obj.toNumber;
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function () { // callback, is called once, after slider finished it's work
                    scope.getIndex();
                }
            });

        }
    }
});

angular.module('app').directive('mileageSlider', function () {
    return {
        restrict: 'A',
        link: function (scope, element) {

            var moved = false;
            var from = scope.mileageFrom;
            var to = scope.mileageTo;
            element.ionRangeSlider({
                min: 1000,
                max: 150000,
                from: from,
                to: to,
                type: 'double',
                step: 5000,
                postfix: " KM",
                maxPostfix: "+",
                minPostfix: "-",
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    scope.mileageFrom = obj.fromNumber;
                    scope.mileageTo = obj.toNumber;
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function () { // callback, is called once, after slider finished it's work
                    scope.getIndex();
                }
            });

        }
    }
});

angular.module('app').directive('yearSlider', function () {
    return {
        restrict: 'A',
        link: function (scope, element) {

            var moved = false;
            var from = scope.yearFrom;
            var to = scope.yearTo;
            element.ionRangeSlider({
                min: 1970,
                max: 2015,
                from: from,
                to: to,
                type: 'double',
                step: 1,
                prettify: false,
                maxPostfix: "+",
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    scope.yearFrom = obj.fromNumber;
                    scope.yearTo = obj.toNumber;
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function () { // callback, is called once, after slider finished it's work
                    scope.getIndex();
                }
            });

        }
    }
});

angular.module('app').directive('favoriteTpl', favoriteTpl);

favoriteTpl.$inject = ['FavoriteService'];

function favoriteTpl(FavoriteService) {
    return {
        restrict: 'EA',
        templateUrl: '/app/views/partials/favorite-tpl.html',
        scope: {
            favoreableType: '@',
            favoreableId: '@'
        },
        link: function link(scope, element) {
            scope.save = function () {
                var postData = {
                    "favoriteable_id": scope.favoreableId,
                    "favoriteable_type": scope.favoreableType
                };
                FavoriteService.save(postData).then(function () {
                    element.html('Favorited').addClass('text-muted text-center');
                });
            };
        }
    };
}



angular.module('app').directive('favoritePanel', favoritePanel);

favoritePanel.$inject = ['FavoriteService'];

function favoritePanel(FavoriteService) {

    return {
        restrict: 'EA',
        templateUrl: '/app/views/partials/favorite-panel.html',
        link: function (scope) {
            scope.destroy = function (favorite) {
                FavoriteService.destroy(favorite).then(function (result) {
                    //element.fadeOut(1000);
                });
            };
        }
    }

}

//angular.module('app').directive('notifyButton', notifyButton);
//
//notifyButton.$inject = ['CarService'];
//
//function notifyButton(CarService) {
//    return {
//        restrict: 'EA',
//        templateUrl: '/app/views/partials/favorite-panel.html',
//        link: function (scope) {
//            scope.destroy = function (favorite) {
//                FavoriteService.delete(favorite).then(function (result) {
//                    //element.fadeOut(1000);
//                });
//            };
//        }
//    }
//}

//angular.module('app').directive('formModal', ['$http', function($http) {
//    return {
//        scope: {
//            formObject: '=',
//            formErrors: '=',
//            title: '@',
//            template: '@',
//            okButtonText: '@',
//            formSubmit: '&'
//        },
//        compile: function(element, cAtts){
//            var template;
//
//            $http.get('templates/form_modal.html')
//                .success(function(response) {
//                    template = response;
//                });
//
//        }
//    }
//}]);

;

//angular.module('app').directive('modal', function () {
//    return {
//        templateUrl: '',
//        restrict: 'E',
//        templateUrl: '/app/views/partials/notification-tpl.html',
//        replace: true,
//        link: function postLink(scope, element, attrs) {
//            scope.$watch(attrs.visible, function (value) {
//                if (value == true)
//                    $(element).modal('show');
//                else
//                    $(element).modal('hide');
//            });
//        }
//    };
//});

//angular.module('app').directive('notificationTpl', notificationTpl);
//
//notificationTpl.$inject = ['NotificationService'];
//
//function notificationTpl(NotificationService) {
//    return {
//        restrict: 'EA',
//        templateUrl: '/app/views/partials/notification-tpl.html',
//        link: function link(scope, element) {
//            scope.save = function () {
//                var postData = {
//                    "type": scope.type
//                };
//                NotificationService.save(postData).then(function () {
//                    //element.html('Favorited').addClass('text-muted text-center');
//                });
//            };
//        }
//    };
//}
//
