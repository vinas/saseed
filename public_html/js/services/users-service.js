app.service('UsersService', function($http, UsersFactory) {

	this.save = function(user)
	{
		return UsersFactory.save(user);
	}

	this.delete = function(id)
	{
		return UsersFactory.delete(id);
	}

	this.isUserDataValid = function(user)
	{
		if (!user.name)
			return false;
		if (!user.email)
			return false;
		return true;
	};

	this.placeUserOnList = function(list, user)
	{
		for (i = 0; i < list.length; i++) {
			if (list[i].id == user.id) {
				list.splice(i, 1);
				break;
			}
		}
		list.push(user);
		return list;
	}

	this.removeUserFromList = function(list, id)
	{
		for (i = 0; i < list.length; i++) {
			if (list[i].id == id) {
				list.splice(i, 1);
				break;
			}
		}
		return list;
	}

	return this;
});