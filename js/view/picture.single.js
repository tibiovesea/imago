App.Views.Picture = Backbone.View.extend({
    el : $('#gallery'),
    
    template : _.template($('#picture-single-template').html()),
    
    className : 'gallery',

    initialize : function() {
        _.bindAll(this, 'render');//, 'renderBreadcrumbs');
        
        this.render();
//        this.renderBreadcrumbs();

        return this;
    },

    render : function() {
        var out = this.template(this.model);
        var fileName = this.model.get('fileName');

        $('title').html(fileName);
        $('#pagination').html('');

        $(this.el).html(out);

        return this;
    }//,

//    renderBreadcrumbs : function() {
//        var breadcrumbs = [
//            {href : this.model.baseHash, name : this.className}
//        ];
//        var tag = this.model.get('tag');
//        if(tag) {
//            var tagHref = this.model.baseHash + this.model.tagPrefix + '/' + tag;
//            breadcrumbs.push({href : tagHref, name : tag});
//        }
//        breadcrumbs.push({href : this.model.hash(), name : this.model.get('fileName')});
//        new App.Views.Breadcrumbs({collection : breadcrumbs});
//    }
});