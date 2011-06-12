App.Controllers.Header = Backbone.Controller.extend({
    header : null,
    picture : null,
    pictureUpload : null,
    tagcloud : null,
    
    initialize : function() {
        _.bindAll(this, 'updateHeader');
        var self = this;

        this.picture = new App.Controllers.Picture();
        this.picture.bind('updateView', this.updateHeader);

        this.pictureUpload = new App.Controllers.PictureUpload();
        
        this.tagcloud = new App.Controllers.TagCloud({
            hash : '#picture'
        });

        this.breadcrumbs = new App.Controllers.Breadcrumbs({
            crumbs : [
                {'picture' : this.picture},
                {'tag' : this.tagcloud}
            ]
        });

        return this;
    },

    updateHeader : function(event) {
        this.tagcloud.refreshView(event);
        this.breadcrumbs.refreshView(event);
    }
});