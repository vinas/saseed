app.controller('adminController', function($scope, $routeParams, $route, CategoryService, PostService) {

    $scope.save = function()
    {
        PostService.save($scope.post).then(function(res) {
            $scope.post = {};
        });

        updateParents();
    };

    $scope.searchForPosts = function(q)
    {
        PostService.getTitleList(q).then(function(res) {
            $scope.titleList = res.data;
        });
    };

    var updateParents = function()
    {
        PostService.getTitleList().then(function(res) {
            $scope.parents = res.data;
        });
    };

    var getCategoryList = function()
    {
        CategoryService.getList().then(function(res) {
            $scope.categories = res.data;
            $scope.post.categoryId = $scope.categories[0].id;
        });
    }

    var init = function() {
        $scope.post = {};
        $scope.parents = [];

        if ($routeParams.id) {
            PostService.get($routeParams.id).then(function(res) {
                $scope.post = res.data;
            });
        }

        if ($route.current.loadables) {
            getCategoryList();
            updateParents();
        }
        
    };

    init();
});