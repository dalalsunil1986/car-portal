angular.module('app').service('NotificationService', NotificationService);

NotificationService.$inject = ['$rootScope','$q','$http','$resource'];

function NotificationService($rootScope, $q , $http, $resource) {

    var resource = $resource('/api/notifications/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        save: save,
        create: create
    };

    return service;

    function save(favorites) {

        resource.save(favorites).$promise.then(
            function (data) {
                deferred.resolve(data);
            },
            function (data) {
                deferred.reject(data);
            }
        );
        return deferred.promise;
    }

    function create(make, brand, type, model, priceFrom, priceTo, mileageFrom, mileageTo, yearFrom, yearTo) {
        var defer = $q.defer();
        $http.get('/api/notifications/create/?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type + '&price_from=' + priceFrom + '&price_to=' + priceTo + '&mileage_from=' + mileageFrom + '&mileage_to=' + mileageTo + '&year_from=' + yearFrom + '&year_to=' + yearTo)
            //.then(function (data) {
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