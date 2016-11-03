app.service('CategoryService', function(CategoryFactory, ResponseService) {

    this.getList = function()
    {
        return CategoryFactory.getList()
            .success(function(categories) {
                if (categories.length > 0)
                    return categories;
                ResponseService.error(601, res, status);
                return [];
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
                return [];
            });
    };

    return this;
});
