angular
    .module('app')
    .controller('CarsController', CarsController);

CarsController.inject = ['$scope', 'CarService', '$location', '$anchorScroll', '$modal','NotificationService'];

function CarsController($scope, CarService, $location, $anchorScroll, $modal, NotificationService) {

    $scope.filters = {};
    $scope.slider = {};

    // Directive Vars
    $scope.slider.type = 'double';
    $scope.slider.maxPostfix = " +";
    $scope.slider.minPostfix = " -";

    $scope.slider.mileageMin = 5000;
    $scope.slider.mileageMax = 300000;
    $scope.slider.mileageStep = 3000;
    $scope.slider.mileagePostfix = " KM";

    $scope.slider.priceMin = 1000;
    $scope.slider.priceMax = 50000;
    $scope.slider.priceStep = 500;
    $scope.slider.pricePostfix = " KD";

    $scope.slider.yearMin = 1970;
    $scope.slider.yearMax = 2015;
    $scope.slider.yearStep = 1;

    // Select Makes,Brands,Types,Models For Car Search Filter
    $scope.filters.selectedMakes = [];
    $scope.filters.selectedBrands = [];
    $scope.filters.selectedTypes = [];
    $scope.filters.selectedModels = [];

    // Get the Names of Selected Filters
    $scope.filters.selectedMakeNames = [];
    $scope.filters.selectedBrandNames = [];
    $scope.filters.selectedTypeNames = [];
    $scope.filters.selectedModelNames = [];

    //Slider Filters
    $scope.filters.priceFrom = 1000;
    $scope.filters.priceTo = 10000;

    $scope.filters.mileageFrom = 6000;
    $scope.filters.mileageTo = 100000;

    $scope.filters.yearFrom = 2005;
    $scope.filters.yearTo = 2014;

    $scope.initCars = function () {

        $scope.resetValues();

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

                // reset page and other initial loading values
                // load cars
                $scope.getCars();
            }
        );
    };

    $scope.getCars = function () {
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
                    NotificationService.create($scope.filters.selectedMakes, $scope.filters.selectedBrands, $scope.filters.selectedTypes, $scope.filters.selectedModels, $scope.filters.priceFrom, $scope.filters.priceTo, $scope.filters.mileageFrom, $scope.filters.mileageTo, $scope.filters.yearFrom, $scope.filters.yearTo)
                        .then(function (data) {
                        }
                    );
                    $modalInstance.dismiss(alert('you will be shortly notified'));
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

    $scope.resetValues = function () {
        $scope.page = 0;
        $scope.cars = [];
        $scope.hasRecord = true;
        $scope.loading = false;
    }

    $scope.refreshCars = function () {
        $scope.resetValues();
        $scope.getCars();
    }

    // Model Watchers
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
