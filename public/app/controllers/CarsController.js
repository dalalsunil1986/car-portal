angular
    .module('app')
    .controller('CarsController', CarsController);

CarsController.inject = ['$scope', 'CarService', '$location', '$anchorScroll'];

function CarsController($scope, CarService, $location, $anchorScroll) {

    $scope.filter = {};
    $scope.filter.selectedMakes = [];
    $scope.filter.selectedBrands = [];
    $scope.filter.selectedTypes = [];
    $scope.filter.selectedModels = [];

    $scope.selectedMakeNames = {};
    $scope.selectedBrandNames = {};
    $scope.selectedTypeNames = {};
    $scope.selectedModelNames = {};

    $scope.showModal = false;

    $scope.toggleModal = function () {
        $scope.showModal = !$scope.showModal;
        if ($scope.showModal) {
            $scope.getFilterNames();
        }
    };

    $scope.getFilterNames = function() {
        CarService.getFilterNames($scope.filter.selectedMakes, $scope.filter.selectedBrands, $scope.filter.selectedTypes, $scope.filter.selectedModels)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.selectedMakeNames = data.results.makes;
                $scope.selectedBrandNames = data.results.brands;
                $scope.selectedTypeNames = data.results.types;
                $scope.selectedModelNames = data.results.models;
            }
        );
    }

    $scope.notifyMe = function () {
        CarService.notifyMe($scope.filter.selectedMakes, $scope.filter.selectedBrands, $scope.filter.selectedTypes, $scope.filter.selectedModels, $scope.priceFrom, $scope.priceTo, $scope.mileageFrom, $scope.mileageTo, $scope.yearFrom, $scope.yearTo)
            .then(function (data) {

            }
        );
    }

    $scope.initCars = function () {

        $scope.page = 0;
        $scope.cars = [];
        $scope.hasRecord = true;
        $scope.loading = false;

        CarService.getFilter($scope.filter.selectedMakes, $scope.filter.selectedBrands, $scope.filter.selectedTypes, $scope.filter.selectedModels)
            .then(function (data) {
                // GET the makes,brands,models,types with unique values, excluding the values which are already selected
                $scope.makes = data.results.makes;
                $scope.brands = data.results.brands;
                $scope.types = data.results.types;
                $scope.models = data.results.models;
                // Selected Values
                $scope.filter.selectedBrands = data.results.brandsArray;
                $scope.filter.selectedModels = data.results.modelsArray;

                $scope.getIndex();
            }
        );
    };

    $scope.getIndex = function () {

        $scope.page++;

        if ($scope.hasRecord) {

            $scope.loading = true;

            CarService.getIndex($scope.filter.selectedMakes, $scope.filter.selectedBrands, $scope.filter.selectedTypes, $scope.filter.selectedModels, $scope.priceFrom, $scope.priceTo, $scope.mileageFrom, $scope.mileageTo, $scope.yearFrom, $scope.yearTo, $scope.page).then(function (response) {

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

    // initially call on load
    $scope.initCars();

    $scope.$watch('filter.selectedMakes', function (newVal, oldVal) {
        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filter.selectedBrands', function (newVal, oldVal) {

        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filter.selectedTypes', function (newVal, oldVal) {
        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.$watch('filter.selectedModels', function (newVal, oldVal) {

        if (!(newVal)) return;

        if (oldVal == newVal) return;

        $scope.initCars();

    }, true);

    $scope.priceFrom = 1000;
    $scope.priceTo = 50000;

    $scope.mileageFrom = 5000;
    $scope.mileageTo = 150000;

    $scope.yearFrom = 1970;
    $scope.yearTo = 2014;

}
