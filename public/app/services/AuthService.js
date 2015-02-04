app.factory('AuthService', function ($http, $q,$sanitize,CSRF_TOKEN,SessionService,$rootScope) {

    var cacheSession   = function(user) {
        SessionService.set('user.authenticated', true);
        SessionService.set('user.name', user.name);
        SessionService.set('user.email', user.email);
    };

    var uncacheSession = function() {
        SessionService.forget('user.authenticated');
        SessionService.forget('user.name');
        SessionService.forget('user.email');
    };

    var sanitizeCredentials = function(credentials) {
        return {
            email: $sanitize(credentials.email),
            password: $sanitize(credentials.password),
            password_confirmation: $sanitize(credentials.password_confirmation),
            name:$sanitize(credentials.name),
            _token: CSRF_TOKEN
        };
    };

    return {
        isLoggedIn : function() {
            return SessionService.get('user.authenticated');
            //return true;
        },
        getUsername : function() {
            return SessionService.get('user.name');
        },
        getEmail : function() {
            return SessionService.get('user.email');
        },
        postRegister: function (data) {
            var defer = $q.defer();
            $http.post("/api/register", sanitizeCredentials(data)).success(function (data) {
                    defer.resolve(data);
                }
            ).error(function (data) {
                    defer.reject(data);
                }
            );
            return defer.promise;
        },

        postLogin: function (data) {
            var defer = $q.defer();
            data._token = CSRF_TOKEN;

            $http.post('/api/signin', data).
                success(function (data) {
                    cacheSession(data.user);
                    $rootScope.$broadcast('auth.update');
                    defer.resolve(data);
                }
            ).error(function (data) {
                    defer.reject(data);
                }
            );
            return defer.promise;
        },

        getLogout :function () {
            var defer = $q.defer();
            $http.get('/api/logout').
                success(function (data) {
                    uncacheSession();
                    $rootScope.$broadcast('auth.update');
                    defer.resolve(data);
                }
            ).error(function (data) {
                    defer.reject(data);
                }
            );
            return defer.promise;

        }

    }

});