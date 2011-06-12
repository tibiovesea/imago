App.Collections.TagCloud = Backbone.Collection.extend({
    model : App.Models.TagCloud,

    baseUrl : '?api=picture/tag',

    url : function() {
        return this.baseUrl;
    }
});