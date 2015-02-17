angular.module('app').service('NotificationService', NotificationService);

NotificationService.$inject = ['$rootScope', '$q', '$http', '$resource'];

function NotificationService($rootScope, $q, $http, $resource) {

    var resource = $resource('/api/notifications/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        save: save,
        create: create
    };

    return service;

    function save(filters) {

        resource.save(filters).$promise.then(
            function (data) {
                deferred.resolve(data);
            },
            function (data) {
                deferred.reject(data);
            }
        );
        return deferred.promise;
    }

    //function create(filterType, make, brand, type, model, priceFrom, priceTo, mileageFrom, mileageTo, yearFrom, yearTo) {
    function create(filters) {
        var defer = $q.defer();

        $http({
            url: '/api/notifications/store',
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                'filter_type': filters.type,
                'make': filters.make,
                'brand': filters.brand,
                'model': filters.model,
                'type': filters.type,
                'price_from': filters.priceFrom,
                'price_to': filters.priceTo,
                'mileage_from': filters.mileageFrom,
                'mileage_to': filters.mileageTo,
                'year_from': filters.yearFrom,
                'year_to': filters.yearTo
            }
        })

            //$http.post('/api/notifications/create', {
            //    'filter_type': filterType,
            //    'make': make,
            //    'brand': brand,
            //    'model': model,
            //    'type': type,
            //    'price_from': priceFrom,
            //    'price_to': priceTo,
            //    'mileage_from': mileageFrom,
            //    'mileage_to': mileageTo,
            //    'year_from': yearFrom,
            //    'year_to': yearTo
            //
            //})
            .success(function (data) {
                // success
                defer.resolve(data);

            },
            function (data) { // optional
                // failed
                defer.reject('An error has occurred ');
            }
        );
        return defer.promise;


        //$http.post("/api/register", sanitizeCredentials(data)).success(function (data) {
        //        defer.resolve(data);
        //    }
        //).error(function (data) {
        //        defer.reject(data);
        //    }
        //);
        //return defer.promise;

        //$http.post('/api/notifications/create','filter_type=' + filterType + '&make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type + '&price_from=' + priceFrom + '&price_to=' + priceTo + '&mileage_from=' + mileageFrom + '&mileage_to=' + mileageTo + '&year_from=' + yearFrom + '&year_to=' + yearTo)
        //    //.then(function (data) {
        //    .success(function (data) {
        //        defer.resolve(data);
        //    }
        //).error(function () {
        //        defer.reject('An error has occurred ');
        //    }
        //);
        //return defer.promise;
    }


}