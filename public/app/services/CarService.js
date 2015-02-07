    angular
        .module('app')
        .factory('CarService', CarService);

    CarService.inject = ['$http', '$q'];

    var sanitizeCredentials = function(credentials) {
        return {
            email: $sanitize(credentials.email),
            password: $sanitize(credentials.password),
            password_confirmation: $sanitize(credentials.password_confirmation),
            name:$sanitize(credentials.name),
            _token: CSRF_TOKEN
        };
    };

    function CarService($http, $q) {

        return {
            getFilter: getFilter,
            getIndex: getIndex,
            getView: getView,
            getFilterNames:getFilterNames,
            notifyMe:notifyMe
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

        function getIndex(make, brand, type, model, priceFrom, priceTo, mileageFrom, mileageTo, yearFrom, yearTo, page) {

            var defer = $q.defer();
            $http.get('/api/cars?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type + '&price-from=' + priceFrom + '&price-to=' + priceTo + '&mileage-from=' + mileageFrom + '&mileage-to=' + mileageTo + '&year-from=' + yearFrom + '&year-to=' + yearTo + '&page=' + page)
                .success(function (data) {
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

        function notifyMe(make, brand, type, model, priceFrom, priceTo, mileageFrom, mileageTo, yearFrom, yearTo) {
            var defer = $q.defer();
            $http.get('/api/cars/notify-me/?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type + '&price-from=' + priceFrom + '&price-to=' + priceTo + '&mileage-from=' + mileageFrom + '&mileage-to=' + mileageTo + '&year-from=' + yearFrom + '&year-to=' + yearTo)
                .success(function (data) {
                    defer.resolve(data);
                }
            ).error(function () {
                    defer.reject('An error has occurred ');
                }
            );
            return defer.promise;
        }

    }