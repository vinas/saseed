var app = angular.module('app', ['ngRoute'])
	.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(false);
		$routeProvider
			.when('/', {
				redirectTo: '/home'
			})
			.when('/home', {
				templateUrl: 'templates/home.html'
			})
			.when('/users', {
				templateUrl: 'templates/users-main.html',
				controller: 'usersController'
			})
			.when('/users/new', {
				templateUrl: 'templates/users-form.html',
				controller: 'usersController'
			})
			.when('/users/edit/:id', {
				templateUrl: 'templates/users-form.html',
				controller: 'usersController'

			})
			.otherwise({
				redirectTo: '/home',
			})
	}]);
