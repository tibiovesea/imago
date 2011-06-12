App.Views.Header = Backbone.View.extend({
    el : $('header'),
//    template : _.template($('#header-template').html()),

    initialize : function() {
        _.bindAll(this, 'render');
        
        this.render();

        return this;
    },

    render : function() {
        $(this.el).html('');
        
        return this;
    }
});