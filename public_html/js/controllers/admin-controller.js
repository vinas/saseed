app.controller('adminController', function($scope, CategoryService, PostService) {

    $scope.save = function()
    {
        PostService.save($scope.post).then(function(res) {
            $scope.post = {};
            
        });

        updateParents();
    };

    var updateParents = function()
    {
        PostService.getTitleList().then(function(res) {
            $scope.parents = res.data;
        });
    };

    var init = function() {
        $scope.post = {};
        $scope.parents = [];
        
        CategoryService.getList().then(function(res) {
            $scope.categories = res.data;
            $scope.post.categoryId = $scope.categories[0].id;
        });

        updateParents();
    };

    init();
});