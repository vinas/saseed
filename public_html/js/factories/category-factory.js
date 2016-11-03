app.factory('CategoryFactory', function($http) {

    this.getList = function()
    {
        return $http.get('api/Category/getList/');
    };

    return this;
});
