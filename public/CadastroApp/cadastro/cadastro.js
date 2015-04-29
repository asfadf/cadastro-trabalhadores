angular.module('CadastroApp')

.controller('CadastroController', function ($scope, $http) {

    $scope.fields = [];

    $scope.showForm = false;

    $scope.trabalhador = {};

    $http.get('/api/volunteer/fields').then(function(response) {
        $scope.fields = response.data;
        $scope.showForm = true;
    });

    var parseVolunteerValues = function() {
        $scope.trabalhador;
    };

    $scope.submitForm = function () {

        $http.post('/api/volunteer', $scope.trabalhador).then(function(response) {
            window.location = '/generate-pdf';
        });
    }

    $scope.notSorted = function(obj) {
        if (!obj) {
            return [];
        }

        return Object.keys(obj);
    };

});