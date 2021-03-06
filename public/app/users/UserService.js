app.factory('AuthService', function ($http, $q,$sanitize,CSRF_TOKEN) {

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