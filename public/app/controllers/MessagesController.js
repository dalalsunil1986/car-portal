app.controller('MessagesController', function ($scope, MessageService, $rootScope, $location) {

    $scope.messages = {}

    $scope.getMessages = function () {
        MessageService.getAll().then(function (data) {
            $scope.messages = data.messages;
        });
    }

    $scope.saveMessage = function (messages) {
        MessageService.save(messages)
            .then(function (data) {
                $('#messageDiv').html(data.message);
            },
            function(data){
                console.log(data.message);
                $('#messageDiv').html(data.message);
            }
            );
    }
    //$scope.getMessages();
});