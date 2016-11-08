app.controller('usersController', function($scope, $routeParams, $location, UsersFactory, UsersService) {
 	
 	$scope.listUsers = function()
 	{
		UsersFactory.getUsersList()
            .success(function(users) {
                $scope.users = users.content;
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
                $scope.user = user.content;
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
			UsersService.save($scope.user)
				.success(function(user) {
					if (user.code != 200) {
						console.log('Error: ' + user.message);
						return false;
					}
					$scope.users = UsersService.placeUserOnList($scope.users, user.content);
					$location.url('users/');
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
					console.log(res);
					if (res.code != 200) {
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