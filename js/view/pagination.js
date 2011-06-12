App.Views.Pagination = Backbone.View.extend({
    el : $('#pagination'),

    template : _.template($('#pagination-template').html()),
    
    hash : '#picture',

    initialize : function() {
        _.bindAll(this, 'render');

        this.render();

        return this;
    },

    render : function(){
        var self = this;

        if(this.collection.pageTotal > 1) {
            var baseHash = this.collection.hash(false);

            var previousUrl = baseHash + (this.collection.previousPage() != 0 ? this.collection.paginationPrefix + this.collection.previousPage() : '');
            var nextUrl = baseHash + this.collection.paginationPrefix + this.collection.nextPage();

            var pagination = self.template({
                        previousUrl : previousUrl,
                        nextUrl : nextUrl
                    });
            
            $(this.el).html(pagination);
        } else {
            $(this.el).html('');
        }

        return this;
    }
});