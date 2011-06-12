App.Models.Breadcrumbs = Backbone.Model.extend({
    href : function(){
        var hrefParts = '';
        if(this.attributes.hrefParts) {
            hrefParts = '/' + this.attributes.hrefParts.join('/');
        }
        return this.attributes.baseHash + hrefParts;
    }
});