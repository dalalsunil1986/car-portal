angular.module('app').service('FavoriteService', FavoriteService);

FavoriteService.$inject = ['$rootScope', '$http', '$q', '$resource'];

function FavoriteService($rootScope, $http, $q, $resource) {

    var resource = $resource('/api/favorites/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        favorites: '',
        list: list,
        save: save,
        destroy: destroy
    };

    return service;

    function list() {

        resource.query().$promise.then(
            function (data) {
                deferred.resolve(data);

                service.favorites = data;
            },
            function (data) {
                deferred.reject(data);
            }
        );
        return deferred.promise;
    }

    function save(favorite) {

        resource.save(favorite,
            function (data) {
                deferred.resolve(data);
                service.favorites.push(data);
                $rootScope.$broadcast('favorites.update');
            },
            function (data) {
                deferred.reject(data);
            });

        return deferred.promise;

    }

    function destroy(favorite) {
        return $http.delete('api/favorites/' + favorite.id).then(function () {

            var index = service.favorites.indexOf(favorite);

            service.favorites.splice(index, 1);

            $rootScope.$broadcast('favorites.update');

        });
    }

}