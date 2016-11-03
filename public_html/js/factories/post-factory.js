app.factory('PostFactory', function($http) {

    this.getTitleList = function()
    {
        return $http.get('api/Post/getTitleList/');
    };

    this.save = function(post)
    {
        return $http.post('api/Post/save/', $.param(post),
                {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                }
            );
    };

    this.get = function(id)
    {
        return $http.get('api/Post/get/'+id);
    };

    this.getChildren = function(id)
    {
        return $http.get('api/Post/getChildren/'+id);
    };

    return this;
});
