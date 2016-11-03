app.controller('docController', function($scope, PostFactory) {
    $scope.post = {};

    $scope.getPost = function(id)
    {
        PostFactory.get(id).then(function(res) {
            $scope.post = res.data;
        });
    };

    ver init() = function()
    {
        $scope.getPost(0);
    };

    init();
});