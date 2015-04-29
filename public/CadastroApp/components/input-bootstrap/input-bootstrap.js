angular.module('inputBootstrap', ['inputMask'])

.directive('inputBootstrap', function() {
    return {
        require: ['ngModel', '^form'],
        restrict: 'E',
        scope: {
            field: '=fieldData'
        },
        templateUrl: 'CadastroApp/components/input-bootstrap/input-bootstrap.html',
        link: function(scope, element, attributes, ctrls) {
            var ngModelCtrl = ctrls[0];
            var ngFormCtrl = ctrls[1];

            scope.form = ngFormCtrl;
            scope.input = {selected: null};

            scope.$watch('input.selected', function(newData, oldData) {
                if (newData) {
                    if (scope.field.type === 'date') {
                        var parts = newData.split('/');

                        if (parts.length === 3 && parts[2].length === 4) {
                            newData = parts[2]+'-'+parts[1]+'-'+parts[0]+' 00:00:00';
                        } else {
                            newData = '';
                        }
                    }
                    ngModelCtrl.$setViewValue(newData);
                }
            }, true);



            scope.addSingleSelectionAsInt = function(value) {
                ngModelCtrl.$setViewValue(parseInt(value));
            };

            scope.addMultipleSelectionAsInt = function(value) {
                if (scope.input.selected === null) {
                    scope.input.selected = [];
                }

                var indexOf = scope.input.selected.indexOf(value);
                if (indexOf === -1) { // Adiciona
                    scope.input.selected.push(parseInt(value));
                } else { // Remove
                    scope.input.selected.splice(indexOf, 1);
                }
            };
        }
    };
});