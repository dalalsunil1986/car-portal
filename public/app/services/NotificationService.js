angular.module('app').service('NotificationService', NotificationService);

NotificationService.$inject = ['$rootScope','$q' ,'$resource'];

function NotificationService($rootScope, $q ,$resource) {

    var resource = $resource('/api/notifications/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        save: save
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

}