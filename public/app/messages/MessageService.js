app.factory( 'MessageService', ['$resource', '$q', function( $resource, $q ) {
    var resource = $resource( '/api/messages/:id', {id: '@id'});
    return {
        getAll : function() {
            var deferred = $q.defer();

            resource.query().$promise.then(
                function(data){
                    deferred.resolve(data);
                },
                function(data) {
                    deferred.reject(data);
                }
            );
            return deferred.promise;
        },
        save :function(messages) {
            var deferred = $q.defer();

            resource.save(messages).$promise.then(
                function(data){
                    deferred.resolve(data);
                },
                function(data) {
                    deferred.reject(data);
                }
            );
            return deferred.promise;
        }
    }
}]);