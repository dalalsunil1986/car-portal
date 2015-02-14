angular.module('app').service('FavoriteService', FavoriteService);

FavoriteService.$inject = ['$rootScope', '$http', '$q', '$resource'];

function FavoriteService($rootScope, $http, $q, $resource) {

    var resource = $resource('/api/favorites/:id', {id: '@id'});
    var defer = $q.defer();

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

                defer.resolve(data);

                service.favorites = data;
            },
            function (data) {
                defer.reject(data);
            }
        );
        return defer.promise;
    }

    function save(favorite) {

        //resource.save(favorite).$promise.then(
        //    function (data) {
        //
        //        service.favorites.push(data);
        //
        //        $rootScope.$broadcast('favorites.update');
        //
        //    },
        //    function (data) {
        //        defer.reject(data);
        //    }
        //);
        //return defer.promise;

        var data = resource.save(favorite);
        service.favorites.push(data);
        $rootScope.$broadcast('favorites.update');

        return data;
    }

    function destroy(favorite) {
        //return resource.delete({ id:id });
        console.log('deleting favorite ' + favorite.id);
        return $http.delete('api/favorites/' + favorite.id).then(function () {

            var index = service.favorites.indexOf(favorite);

            service.favorites.splice(index, 1);

            $rootScope.$broadcast('favorites.update');

        });
    }

}