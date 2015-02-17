angular.module('app').service('NotificationService', NotificationService);

NotificationService.$inject = ['$q', '$http', '$resource', 'CSRF_TOKEN'];

function NotificationService($q, $http, $resource, CSRF_TOKEN) {

    var resource = $resource('/api/notifications/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        save: save
    };

    return service;

    function save(filters) {

        filters._token = CSRF_TOKEN;

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

}