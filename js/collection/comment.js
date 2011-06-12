App.Collections.Comment = Backbone.Collection.extend({
    model : App.Models.Comment,
    url : function() {
        var base = '?api=picture/' + this.picture + '/comment';
        if(!this.page) {
            return base;
        }
        return base + '/p' + this.page;
    }
});