app.factory('UsersFactory', function($http) {

	this.getUsersList = function()
	{

		return $http.get('api/Users/listUsers/');
	}

	this.getUserById = function(id)
	{
        return $http.get('api/Users/getUser/'+id);
	}

	this.save = function(user)
	{
		return $http.post('api/Users/save/', $.param(user),
				{
					headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
        		}
			);
	}

	this.delete = function(id)
	{
        return $http.get('api/Users/delete/'+id);
	}

	return this;
})