app.controller('UsersController', function ($scope, AuthService, $rootScope, $location) {

    $scope.user = {}

    $rootScope.loggedIn = AuthService.isLoggedIn();
    $rootScope.username = AuthService.getUsername();
    $rootScope.email = AuthService.getEmail();

    $scope.register = function () {
        AuthService.postRegister($scope.user).then(function (data) {
                $location.path('/');
                $rootScope.alert = {showAlert: true, msg: data.message, alertClass: data.class};
            },
            function (data) {
                $rootScope.alert = {showAlert: true, msg: data.message, alertClass: data.class};
            });
    };

    $scope.login = function () {
        AuthService.postLogin($scope.user).then(function (data) {
                $location.path('/');
                $rootScope.alert = {showAlert: true, msg: data.message, alertClass: data.class};
            },
            function (data) {
                $rootScope.alert = {showAlert: true, msg: data.message, alertClass: data.class};
            });
    }

    $scope.logout = function () {
        AuthService.getLogout().then(function (data) {
            $location.path('/');
            $rootScope.alert = {showAlert: true, msg: data.message, alertClass: data.class};
        });
    }

    $scope.$on('auth.update', function () {
        $rootScope.loggedIn = AuthService.isLoggedIn();
        $rootScope.username = AuthService.getUsername();
        $rootScope.email = AuthService.getEmail();
    });

});