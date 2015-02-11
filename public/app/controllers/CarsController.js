angular
    .module('app')
    .controller('CarsController', CarsController);

CarsController.inject = ['$scope', 'CarService', '$location', '$anchorScroll', '$modal'];

function CarsController($scope, CarService, $location, $anchorScroll, $modal) {

    $scope.filters = {};
    $scope.filters.selectedMakes = [];
    $scope.filters.selectedBrands = [];
    $scope.filters.selectedTypes = [];
    $scope.filters.selectedModels = [];
    $scope.filters.selectedMakeNames = [];
    $scope.filters.selectedBrandNames = [];
    $scope.filters.selectedTypeNames = [];
    $scope.filters.selectedModelNames = [];
    $scope.filters.priceFrom = 1000;
    $scope.filters.priceTo = 50000;
    $scope.filters.mileageFrom = 5000;
    $scope.filters.mileageTo = 150000;
    $scope.filters.yearFrom = 1970;
    $scope.filters.yearTo = 2014;

    $scope.initCars = function () {

        $scope.page = 0;
        $scope.cars = [];
        $scope.hasRecord = true;
        $scope.loading = false;

        CarService.getFilter($scope.filters.selectedMakes, $scope.filters.selectedBrands, $scope.filters.selectedTypes, $scope.filters.selectedModels)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.makes = data.results.makes;
                $scope.brands = data.results.brands;
                $scope.types = data.results.types;
                $scope.models = data.results.models;
                // Selected Values
                $scope.filters.selectedBrands = data.results.brandsArray;
                $scope.filters.selectedModels = data.results.modelsArray;

                $scope.getIndex();
            }
        );
    };

    $scope.getIndex = function () {

        $scope.page++;

        if ($scope.hasRecord) {

            $scope.loading = true;

            CarService.getIndex($scope.filters.selectedMakes, $scope.filters.selectedBrands, $scope.filters.selectedTypes, $scope.filters.selectedModels, $scope.filters.priceFrom, $scope.filters.priceTo, $scope.filters.mileageFrom, $scope.filters.mileageTo, $scope.filters.yearFrom, $scope.filters.yearTo, $scope.page).then(function (response) {

                $scope.sortorder = "-created_at";

                // If Data retrieved is equal, then just return
                if (angular.equals(response.data, $scope.cars)) {
                    return;
                }

                angular.forEach(response.data, function (d) {
                    this.push(d);
                }, $scope.cars);

                $location.hash('Hf31x6' + response.from);

                $anchorScroll();

                // if there is no more record, set has Records to false so that no more ajax requests are sent to server
                if (response.next_page_url == null) {
                    $scope.hasRecord = false;
                }
                $scope.loading = false;
            });
        }
    };

    $scope.openModal = function (size, selectedFilters) {
        $scope.getFilterNames();
        var modalInstance = $modal.open({
            templateUrl: '/app/views/partials/notification-tpl.html',
            controller: function ($scope, $modalInstance, filters) {
                $scope.filters = filters;
                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };
                $scope.notifyMe = function () {
                    CarService.notifyMe($scope.filters.selectedMakes, $scope.filters.selectedBrands, $scope.filters.selectedTypes, $scope.filters.selectedModels, $scope.priceFrom, $scope.priceTo, $scope.mileageFrom, $scope.mileageTo, $scope.yearFrom, $scope.yearTo)
                        .then(function (data) {
                        }
                    );
                    $modalInstance.dismiss('cancel');
                };
            },
            size: size,
            resolve: {
                filters: function () {
                    return $scope.filters = selectedFilters;
                }
            }
        });

        modalInstance.result.then(function (selectedFilters) {
            $scope.filters = selectedFilters;
        }, function () {
            console.log($scope.filters.selectedMakeNames);
        });
    };

    $scope.getFilterNames = function () {
        CarService.getFilterNames($scope.filters.selectedMakes, $scope.filters.selectedBrands, $scope.filters.selectedTypes, $scope.filters.selectedModels)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.filters.selectedMakeNames = data.results.makes;
                $scope.filters.selectedBrandNames = data.results.brands;
                $scope.filters.selectedTypeNames = data.results.types;
                $scope.filters.selectedModelNames = data.results.models;
            }
        );
    }

    $scope.$watch('filters.selectedMakes', function (newVal, oldVal) {
        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filters.selectedBrands', function (newVal, oldVal) {

        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filters.selectedTypes', function (newVal, oldVal) {
        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filters.selectedModels', function (newVal, oldVal) {

        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

}
