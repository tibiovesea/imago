App.Controllers.TagCloud = Backbone.Controller.extend({
    view : null,
    
    initialize : function(options){
        _.bindAll(this, 'refreshView');

        this.options = options;
        
        this.view = new App.Views.TagCloud({
            hash : this.options.hash
        });

        var self = this;
        var tags = new App.Collections.TagCloud();
        tags.fetch({
            success : function(model, response) {
                self.view.collection = model;
                self.view.render();
            },
            error : function(model, response) {
                new App.Views.Error({
                    message : 'could not load the cloud :(',
                    details : response.responseText
                });
            }
        });

        return this;
    },

    refreshView : function() {
        this.view.render();
    }
});