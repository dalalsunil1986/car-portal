angular.module('app').directive('carResults', function () {
    return {
        restrict: "EA",
        replace: true,
        scope: true,
        templateUrl: '/app/views/cars/result.html'
    }
});

angular.module('app').directive('priceSlider', function () {
    return {
        restrict: 'EA',
        scope: true,
        replace: true,
        link: function (scope, element) {
            var moved = false;
            element.ionRangeSlider({
                min: scope.slider.priceMin,
                max: scope.slider.priceMax,
                from: scope.filters.priceFrom,
                to: scope.filters.priceTo,
                type: scope.slider.type,
                step: scope.slider.priceStep,
                postfix: scope.slider.pricePostfix,
                maxPostfix: scope.slider.maxPostfix,
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.filters.priceFrom = obj.fromNumber;
                    scope.filters.priceTo = obj.toNumber;
                    scope.resetValues();
                    scope.getIndex();
                }
            });

        }
    }
});

angular.module('app').directive('mileageSlider', function () {
    return {
        restrict: 'EA',
        scope: true,
        replace: true,
        link: function (scope, element) {
            var moved = false;
            element.ionRangeSlider({
                min: scope.slider.mileageMin,
                max: scope.slider.mileageMax,
                from: scope.filters.mileageFrom,
                to: scope.filters.mileageTo,
                type: scope.slider.type,
                step: scope.slider.mileageStep,
                postfix: scope.slider.mileagePostfix,
                maxPostfix: scope.slider.maxPostfix,
                minPostfix: scope.slider.minPostfix,
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    scope.filters.mileageFrom = obj.fromNumber;
                    scope.filters.mileageTo = obj.toNumber;
                    scope.$apply();
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.resetValues();
                    scope.filters.mileageFrom = obj.fromNumber;
                    scope.filters.mileageTo = obj.toNumber;
                    scope.getIndex();
                }
            });

        }
    }
});

angular.module('app').directive('yearSlider', function () {
    return {
        restrict: 'EA',
        scope: true,
        replace: true,
        link: function (scope, element) {
            var moved = false;
            element.ionRangeSlider({
                min: scope.slider.yearMin,
                max: scope.slider.yearMax,
                from: scope.filters.yearFrom,
                to: scope.filters.yearTo,
                type: scope.slider.type,

                step: 1,
                prettify: false,
                maxPostfix: "+",
                onChange: function (obj) { // callback, is called on every change
                    moved = true;
                    _.defer(function () {
                        scope.$apply();
                    });
                },
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.resetValues();
                    scope.filters.yearFrom = obj.fromNumber;
                    scope.filters.yearTo = obj.toNumber;
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
