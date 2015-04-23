angular.module('inputMask', [])

.directive('mask', function() {
    return {
        restrict: 'A',
        // scope: {mask: '='},
        link: function(scope, element, attrs) {
            if (attrs.mask) {
                element.mask(attrs.mask);
            }
        }
    }
});