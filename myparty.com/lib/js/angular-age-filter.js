/**
 * For lazy people.
 * Reference / Origin:
 * http://stackoverflow.com/questions/24883308/convert-birthday-to-age-in-angularjs
 */
+function(angular, undefined) {
  'use strict';
  angular
    .module('srph.age-filter', [])
    .filter('age', age);

  function age() {
    return function(input, current) {
      // This syntax is usable in this case
      // NaN || {whatever} evaluates to {whatever}
      current = Date.parse(current) || Date.now();
      
      // Difference in milliseconds
      var ageDiffMs =  current - new Date(input).getTime();
      var ageDate = new Date(ageDiffMs);

      return Math.abs( ageDate.getUTCFullYear() - 1970 );
    }
  }
}(angular);
