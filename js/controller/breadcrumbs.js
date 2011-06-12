App.Controllers.Breadcrumbs = Backbone.Controller.extend({
    view : null,

    initialize : function(options){
        _.bindAll(this, 'refreshView');
        
        this.view = new App.Views.Breadcrumbs();
    },

    refreshView : function(event) {
        this.view.collection = event.breadcrumbs;
        this.view.render();
    }
});