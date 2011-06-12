App.Views.PictureList = Backbone.View.extend({
    el : $('#gallery'),
    template : _.template($('#picture-list-template').html()),

    hash : '#picture',

    className : 'gallery',

    events : {
        'mouseover .picture-wrapper' : 'highlight',
        'mouseout .picture-wrapper' : 'unHighlight'
    },

    initialize : function() {
        _.bindAll(this, 'render', 'highlight', 'unHighlight');

        this.render();

        return this;
    },

    render : function(){
        var out = '';

        var self = this;

        _(this.collection.models).each(function(item){
            out += self.template({model : item});
        });

        $('title').html(this.className);
        $(this.el).html(out);

        return this;
    },

    highlight : function(event) {
        $(event.currentTarget).addClass('mouse-over');
    },

    unHighlight : function(event) {
        $(event.currentTarget).removeClass('mouse-over');
    }
});