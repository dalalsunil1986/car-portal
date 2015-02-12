angular.module('app').service('FavoriteService', FavoriteService);

FavoriteService.$inject = ['$rootScope', '$http', '$q', '$resource'];

function FavoriteService($rootScope, $http, $q, $resource) {

    var resource = $resource('/api/favorites/:id', {id: '@id'});
    var deferred = $q.defer();

    var service = {
        favorites: '',
        list: list,
        save: save,
        destroy: destroy,
        del:del
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

    function save(favorites) {

        resource.save(favorites).$promise.then(
            function (data) {

                deferred.resolve(data);

                service.favorites.push(data);

                $rootScope.$broadcast('favorites.update');
                return data;
            },
            function (data) {
                deferred.reject(data);
            }
        );
        return deferred.promise;
    }

    function destroy(favorite) {
        //return resource.delete({ id:id });
        return $http.delete('api/favorites/' + favorite.id).then(function () {

            var index = service.favorites.indexOf(favorite);

            service.favorites.splice(index, 1);

            $rootScope.$broadcast('favorites.update');

        });
    }

    function del(favoriteableId) {
        //return resource.delete({ id:id });
        return $http.delete('api/favorites/' + favoriteableId).then(function () {

        });
    }

}