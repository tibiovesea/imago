App.Models.TagCloud = Backbone.Model.extend({
    url : function(){
        var base = '?api=picture/tag';
        if(this.isNew()) {
            return base;
        }
        return base + (base.charAt(base.length - 1) === '/' ? '' : '/') + this.id;
    }
});