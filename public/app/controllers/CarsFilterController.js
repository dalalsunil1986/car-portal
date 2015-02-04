app.controller("CarsFilterController",
    function CarsFilterController($scope) {
        $scope.car = {};

        $scope.getAlert =function(make) {
            console.log(make);
            return make;
        }
    }

);