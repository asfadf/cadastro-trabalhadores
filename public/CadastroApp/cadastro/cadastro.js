angular.module('CadastroApp')

.controller('CadastroController', function ($scope, $http) {

    $scope.fields = [];

    $scope.trabalhador = {};

    $http.get('/api/form/fields').then(function(response) {
        $scope.fields = response.data;
    });

    $scope.submitForm = function () {
        console.log($scope.trabalhador);
    }

})

.directive('form', function() {
    return {
        restrict: 'E',
        scope: {fields: '=', data: '=', form: '=name'},
        templateUrl: 'CadastroApp/cadastro/cadastro.html',
        link: function(scope, element, attributes) {

            // Workaround para manter ordem dos campos
            scope.notSorted = function(obj) {
                if (!obj) {
                    return [];
                }

                return Object.keys(obj);
            }

        }
    }
});