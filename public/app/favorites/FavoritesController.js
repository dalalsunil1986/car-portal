angular.module('app').controller('FavoritesController', FavoritesController);

FavoritesController.$inject = ['$scope', 'FavoriteService'];

function FavoritesController($scope, FavoriteService) {

    $scope.favorites = [];
    
    $scope.$on('favorites.update', function () {
        $scope.favorites = FavoriteService.favorites;
    });

    $scope.getFavorites = function() {
        FavoriteService.list().then(function () {
            $scope.favorites = FavoriteService.favorites;
        });
    }

}