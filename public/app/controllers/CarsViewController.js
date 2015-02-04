app.controller('CarsViewController', function ($scope, $stateParams, CarService) {
    $scope.car = {};
    CarService.getView($stateParams.id).then(function (data) {
        $scope.car = data;
    });
});