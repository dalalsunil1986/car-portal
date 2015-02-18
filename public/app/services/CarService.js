angular
    .module('app')
    .factory('CarService', CarService);

CarService.inject = ['$http', '$q'];

function CarService($http, $q) {

    return {
        getFilter: getFilter,
        getIndex: getIndex,
        getView: getView,
        getFilterNames: getFilterNames
    };

    function getFilter(make, brand, type, model) {
        var defer = $q.defer();
        $http.get('/api/cars/filter?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type)
            .success(function (data) {
                defer.resolve(data);
            }
        ).error(function () {
                defer.reject('An error has occurred ');
            }
        );
        return defer.promise;
    }

    function getFilterNames(make, brand, type, model) {
        var defer = $q.defer();
        $http.get('/api/cars/name/?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type)
            .success(function (data) {
                defer.resolve(data);
            }
        ).error(function () {
                defer.reject('An error has occurred ');
            }
        );
        return defer.promise;
    }

    function getIndex(filters) {
        var params = {
            make: filters.selectedMakes,
            brand: filters.selectedBrands,
            type: filters.selectedTypes,
            model: filters.selectedModels,
            price_from: filters.priceFrom,
            price_to: filters.priceTo,
            mileage_from: filters.mileageFrom,
            mileage_to: filters.mileageTo,
            year_from: filters.yearFrom,
            year_to: filters.yearTo,
            page: filters.page
        };
        var defer = $q.defer();
        $http({
            url: 'api/cars',
            method: "GET",
            params: params
        }).success(function (data) {
                defer.resolve(data);
            }
        ).error(function () {
                defer.reject('An error has occurred ');
            }
        );
        return defer.promise;
    }

    function getView(id) {
        var defer = $q.defer();
        $http.get('/api/cars/' + id)
            .success(function (data) {
                defer.resolve(data);
            }
        ).error(function () {
                defer.reject('An error has occurred :(');
            }
        );
        return defer.promise;
    }


}