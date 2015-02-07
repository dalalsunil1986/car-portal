    angular
        .module('app')
        .factory('NotificationService', NotificationService);

    NotificationService.inject = ['$http', '$q'];

    function NotificationService($http, $q) {

        return {
            getFilterNames: getFilterNames
        };

        function getFilterNames(make, brand, type, model) {
            var defer = $q.defer();
            $http.get('/api/notifications/notify/?make=' + make + '&brand=' + brand + '&model=' + model + '&type=' + type)
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