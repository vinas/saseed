app.directive('header', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/header.html'
		}
	})
	.directive('menu', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/menu.html'
		}
	});