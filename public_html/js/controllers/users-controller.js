app.controller('usersController', function($scope, $http, $routeParams, $location, UsersFactory, UsersService) {
 	
 	$scope.listUsers = function()
 	{
		UsersFactory.getUsersList()
            .success(function(users) {
                $scope.users = users;
				$scope.templateURL = 'templates/users-list.html';
            })
            .error(function(res, status) {
                console.log("Error: " + res + "\nStatus: " + status);
            }
		);
	};

	$scope.goEditUser = function(id)
	{
		$location.url('users/edit/'+id);
	}
	
	$scope.getUser = function(id)
	{
		UsersFactory.getUserById(id)
            .success(function(user) {
                $scope.user = user;
				$scope.templateURL = 'templates/users-form.html';
            })
            .error(function(response, status) {
                console.log("Error: " + response + "\nStatus: " + status);
            });
	};

	$scope.newUser = function()
	{
		$scope.user = {};
		$scope.templateURL = 'templates/users-form.html';
	};

	$scope.save = function()
	{
		if (UsersService.isUserDataValid($scope.user)) {
			$scope.user.password = $scope.user.password1;
			UsersService.save($scope.user)
				.success(function(user) {
					if (user.code != 200) {
						console.log('tratar erro: ' + user.message);
						return false;
					}
					$scope.users = UsersService.placeUserOnList($scope.users, user);
					$scope.templateURL = 'templates/users-list.html';
	        	})
	            .error(function(response, status) {
	                console.log("Error: " + response + "\nStatus: " + status);
	            });
		} else {
			console.log('tratar erro: invalid data form.');
		}
	};

	$scope.delete = function(id) {
		if (confirm('You sure?')) {
			UsersService.delete(id)
				.success(function(res) {
					if (res.code != 202) {
						console.log('tratar erro: ' + res.message);
						return false;
					}
					$scope.users = UsersService.removeUserFromList($scope.users, id);
	        	})
	            .error(function(response, status) {
	                console.log("Error: " + response + "\nStatus: " + status);
	            });

		}
	};

	var init = function() {
		if ($routeParams.id) {
			$scope.getUser($routeParams.id);
		} else {
			$scope.listUsers();
		}
	};

	$scope.users = [];
	init();

});