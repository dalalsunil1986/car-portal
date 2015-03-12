angular
    .module('app')
    .controller('CarsController', CarsController);

CarsController.inject = ['$scope', 'CarService', '$location', '$anchorScroll', '$modal', 'NotificationService'];

function CarsController($scope, CarService, $location, $anchorScroll, $modal, NotificationService) {

    $scope.filters = {};
    $scope.slider = {};

    $scope.constructor = function () {
        $scope.filters.page = 0;
        $scope.loading = false;
        $scope.cars = [];
        $scope.hasRecords = true;
        $scope.emptyRecords = false;
    };

    // Directive Vars
    $scope.slider.type = 'double';
    $scope.slider.maxPostfix = " +";
    $scope.slider.minPostfix = " -";
    $scope.slider.forceEdges = true;
    $scope.slider.grid = false;
    $scope.slider.gridNum = 3;
    $scope.slider.gridMargin = true;
    $scope.slider.keyboard = true;

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

    //filters
    $scope.filters.filterType = 'car';
    $scope.filters.page = 0;

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
    $scope.filters.priceTo = 50000;

    $scope.filters.mileageFrom = 5000;
    $scope.filters.mileageTo = 300000;

    $scope.filters.yearFrom = 1970;
    $scope.filters.yearTo = 2015;

    $scope.getCars = function () {

        $scope.loading = true;

        if ($scope.hasRecords) {

            $scope.filters.page++;

            //var response = CarService.getIndex($scope.filters);
            //console.log(response.data);
            CarService.getIndex($scope.filters).then(function (response) {

                $scope.sortorder = "-created_at";

                // If Data retrieved is equal, then just return
                // if there is no more record, set has Records to false so that no more ajax requests are sent to server
                if (angular.equals(response.data, $scope.cars)) {
                    $scope.loading = false;
                    $scope.hasRecords = false;
                    if (!$scope.cars.length) {
                        $scope.emptyRecords = true;
                    }
                    return;
                }

                angular.forEach(response.data, function (response) {
                    this.push(response);
                }, $scope.cars);

                if (response.next_page_url == null) {
                    // set there are no more records . just to avoid unnecessary XHR requests
                    $scope.hasRecords = false;
                }
                $scope.loading = false;
            });
        } else {
            $scope.loading = false;
        }
    };

    $scope.initCars = function () {

        $scope.constructor();

        CarService.getFilter($scope.filters)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.makes = data.results.makes;
                $scope.brands = data.results.brands;
                $scope.types = data.results.types;
                $scope.models = data.results.models;
                // Selected Values
                $scope.filters.selectedBrands = data.results.brandsArray;
                $scope.filters.selectedModels = data.results.modelsArray;

                // load cars
                $scope.getCars();
            }
        );
    };

    $scope.getFilterNames = function () {
        CarService.getFilterNames($scope.filters)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.filters.selectedMakeNames = data.results.makes;
                $scope.filters.selectedBrandNames = data.results.brands;
                $scope.filters.selectedTypeNames = data.results.types;
                $scope.filters.selectedModelNames = data.results.models;
            }
        );
    };

    $scope.openModal = function (size, selectedFilters) {

        $scope.getFilterNames();

        var modalInstance = $modal.open({
            templateUrl: '/app/cars/partials/notify-modal.html',
            controller: function ($scope, $modalInstance, filters) {
                $scope.filters = filters;
                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };
                $scope.notifyMe = function () {
                    NotificationService.save($scope.filters)
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
        });
    };

    $scope.refreshCars = function () {
        $scope.constructor();
        $scope.getCars();
    };

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

        $scope.refreshCars();

    }, true);

}
