angular
    .module('app')
    .factory('CarService', CarService);

CarService.inject = ['$http', '$q','$rootScope'];

function CarService($http, $q,$rootScope) {

    return {
        getFilter: getFilter,
        getIndex: getIndex,
        getView: getView,
        getFilterNames: getFilterNames
    };

    function getFilter(filters) {
        var deferred = $q.defer();
        $http.get('api/cars/filter?make=' + filters.selectedMakes + '&brand=' + filters.selectedBrands + '&type=' + filters.selectedTypes + '&model=' + filters.selectedModels)
            .success(function (data) {
                deferred.resolve(data);
            }
        ).error(function () {
                deferred.reject('An error has occurred ');
            }
        );
        return deferred.promise;
    }

    function getFilterNames(filters) {
        var deferred = $q.defer();

        $http.get('api/cars/name?make=' + filters.selectedMakes + '&brand=' + filters.selectedBrands + '&type=' + filters.selectedTypes + '&model=' + filters.selectedModels)
            .success(function (data) {
                deferred.resolve(data);
            }
        ).error(function () {
                deferred.reject('An error has occurred ');
            }
        );
        return deferred.promise;
    }
//
//    function getIndex(filters) {
//        //var d = $q.defer();
//        //$http.get('api/cars?make=' + filters.selectedMakes + '&brand=' + filters.selectedBrands + '&type=' + filters.selectedTypes + '&model=' + filters.selectedModels +
//        //    '&price_from=' + filters.priceFrom + '&price_to=' + filters.priceTo + '&mileage_from=' + filters.mileageFrom + '&mileage_to=' + filters.mileageTo +
//        //    '&year_from=' + filters.yearFrom + '&year_to=' + filters.yearTo + '&page=' + filters.page
//        //    , {timeout: d.promise}).success(function (result) {
//        //        d.resolve(result);
//        //        console.log('hey');
//        //    }).error(function(result){
//        //        console.log(result);
//        //        console.log('error');
//        //    });
//        ////return d.promise;
//        ////$rootScope.$apply(function() {
//        ////console.log(d);
//        //    return d.promise;
//        //});
//        var canceler = $q.defer();
//
//// use it as a timeout canceler for the request
//        $http({method: 'GET', url: 'api/cars?make=' + filters.selectedMakes + '&brand=' + filters.selectedBrands + '&type=' + filters.selectedTypes + '&model=' + filters.selectedModels +
//                    '&price_from=' + filters.priceFrom + '&price_to=' + filters.priceTo + '&mileage_from=' + filters.mileageFrom + '&mileage_to=' + filters.mileageTo +
//                    '&year_from=' + filters.yearFrom + '&year_to=' + filters.yearTo + '&page=' + filters.page
//            , timeout: canceler.promise}).success(
//            function (data) { console.log('success'); }
//
//    ).error(
//            function (data) { console.log('cancelled'); }
//        )
//
//// now, cancel it (before it may come back with data)
////        $rootScope.$apply(function() {
//            canceler.resolve();
//        //});
//    }

    function getIndex(filters) {
        var deferred = $q.defer();

        $http.get('api/cars?make=' + filters.selectedMakes + '&brand=' + filters.selectedBrands + '&type=' + filters.selectedTypes + '&model=' + filters.selectedModels +
            '&price_from=' + filters.priceFrom + '&price_to=' + filters.priceTo + '&mileage_from=' + filters.mileageFrom + '&mileage_to=' + filters.mileageTo +
            '&year_from=' + filters.yearFrom + '&year_to=' + filters.yearTo + '&page=' + filters.page
        )
            .success(function (data) {
                deferred.resolve(data);
            }
        ).error(function () {
                deferred.reject('An error has occurred ');
            }
        );

        return deferred.promise;

    }

    function getView(id) {
        var deferred = $q.defer();
        $http.get('/api/cars/' + id)
            .success(function (data) {
                deferred.resolve(data);
            }
        ).error(function () {
                deferred.reject('An error has occurred :(');
            }
        );
        return deferred.promise;
    }


}