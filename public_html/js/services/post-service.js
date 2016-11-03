app.service('PostService', function(PostFactory, ResponseService) {

    this.getTitleList = function()
    {
        return PostFactory.getTitleList()
            .success(function(parents) {
                if (parents.length > 0)
                    return parents;
                ResponseService.error(601);
                return [];
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
                return [];
            });
    };

    this.save = function(post)
    {
        return PostFactory.save(post)
            .success(function(res) {
                if (res.id) {
                    ResponseService.ok('Post saved!');
                    return res;
                }
                ResponseService.error(601);
                return post;
            })
            .error(function(response, status) {
                ResponseService.error(600, res, status);
                return post;
            });
    };

    return this;
});