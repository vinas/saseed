var app = angular.module('saSeed', ['ngRoute'])
	.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(false);
		$routeProvider
			.when('/', {
				redirectTo: '/home'
			})
			.when('/home', {
				templateUrl: 'templates/home.html'
			})
			.when('/why-saseed', {
				templateUrl: 'templates/why-saseed.html'
			})
			.when('/download', {
				redirectTo: '/home'
			})
			.when('/install', {
				templateUrl: 'templates/install.html'
			})
			.when('/install/linux', {
				templateUrl: 'templates/install-linux.html'
			})
			.when('/install/windows', {
				templateUrl: 'templates/install-windows.html'
			})
			.when('/install/xampp-doc-root', {
				templateUrl: 'templates/xampp-doc-root.html'
			})
			.when('/documentation', {
				templateUrl: 'templates/documentation.html',
				controller: 'docController'
			})
			.when('/contact', {
				templateUrl: 'templates/contact.html'
			})
			.when('/admin', {
				templateUrl: 'templates/admin-form.html',
				controller: 'adminController'
			})
			.otherwise({
				redirectTo: '/home'
			});
	}]);
