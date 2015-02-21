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
        replace: true,
        scope: true,
        link: function (scope, element) {
            element.ionRangeSlider({
                min: scope.slider.priceMin,
                max: scope.slider.priceMax,
                type: scope.slider.type,
                step: scope.slider.priceStep,
                postfix: scope.slider.pricePostfix,
                maxPostfix: scope.slider.maxPostfix,
                from: scope.filters.priceFrom,
                to: scope.filters.priceTo,
                force_edges: scope.slider.forceEdges,
                grid: scope.slider.grid,
                grid_num: scope.slider.gridNum,
                grid_margin: scope.slider.gridMargin,
                keyboard: scope.slider.keyboard,
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.filters.priceFrom = obj.from;
                    scope.filters.priceTo = obj.to;
                    scope.refreshCars();
                }
            });

        }

    }
});

angular.module('app').directive('mileageSlider', function () {
    return {
        restrict: 'EA',
        replace: true,
        scope: true,
        link: function (scope, element) {
            element.ionRangeSlider({
                min: scope.slider.mileageMin,
                max: scope.slider.mileageMax,
                type: scope.slider.type,
                step: scope.slider.mileageStep,
                postfix: scope.slider.mileagePostfix,
                maxPostfix: scope.slider.maxPostfix,
                minPostfix: scope.slider.minPostfix,
                from: scope.filters.mileageFrom,
                to: scope.filters.mileageTo,
                force_edges: scope.slider.forceEdges,
                grid: scope.slider.grid,
                grid_num: scope.slider.gridNum,
                grid_margin: scope.slider.gridMargin,
                keyboard: scope.slider.keyboard,
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.filters.mileageFrom = obj.from;
                    scope.filters.mileageTo = obj.to;
                    scope.refreshCars();
                }
            });

        }
    }
});

angular.module('app').directive('yearSlider', function () {
    return {
        restrict: 'EA',
        replace: true,
        scope: true,
        link: function (scope, element) {
            element.ionRangeSlider({
                min: scope.slider.yearMin,
                max: scope.slider.yearMax,
                type: scope.slider.type,
                step: scope.slider.yearStep,
                maxPostfix: scope.slider.maxPostfix,
                from: scope.filters.yearFrom,
                to: scope.filters.yearTo,
                force_edges: scope.slider.forceEdges,
                grid: scope.slider.grid,
                grid_num: scope.slider.gridNum,
                grid_margin: scope.slider.gridMargin,
                keyboard: scope.slider.keyboard,
                onFinish: function (obj) { // callback, is called once, after slider finished it's work
                    scope.filters.yearFrom = obj.from;
                    scope.filters.yearTo = obj.to;
                    scope.refreshCars();
                }
            });

        }
    }
});

angular.module('app').directive('favoriteButton', favoriteButton);

favoriteButton.$inject = ['FavoriteService'];

function favoriteButton(FavoriteService) {
    return {
        restrict: 'EA',
        templateUrl: '/app/cars/partials/favorite-button.html',
        scope: {
            favoreableType: '@',
            favoreableId: '@',
            favorite: '='
        },
        link: function link(scope) {

            scope.save = function () {
                scope.favorite = {}; // just to change the text to remove
                var postData = {
                    "favoriteable_id": scope.favoreableId,
                    "favoriteable_type": scope.favoreableType
                };

                FavoriteService.save(postData).then(function (favorite) {
                    scope.favorite = favorite;
                })

            };

            scope.destroy = function () {
                if (typeof scope.favorite != 'object') {
                    return false;
                }
                FavoriteService.destroy(scope.favorite);
                scope.favorite = null;
            };
        }
    };
}
