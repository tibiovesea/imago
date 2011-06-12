App.Views.Breadcrumbs = Backbone.View.extend({
    el : $('#breadcrumbs'),
    template : _.template($('#breadcrumbs-template').html()),

    className : 'breadcrumbs',

    initialize : function() {
        _.bindAll(this, 'render');

        this.render();

        return this;
    },

    render : function() {
        var out = '';
        var self = this;

        if(this.collection && this.collection.models) {
            _(this.collection.models).each(function(item){
                out += self.template(item);
            });
        }

        $(this.el).html(out);
        return this;
    }
});