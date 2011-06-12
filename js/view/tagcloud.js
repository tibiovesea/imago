App.Views.TagCloud = Backbone.View.extend({
    el : $('#tagcloud'),

    template : _.template($('#tagcloud-template').html()),
    tagTemplate : _.template($('#tag-template').html()),

    events : {
        'click #tagcloud .toggle a' : 'toggleCloud',
        'click #tagcloud .content a' : 'loadTagPictures'
    },

    initialize : function(options) {
        _.bindAll(this, 'render', 'toggleCloud', 'loadTagPictures');

        if(options.hash) {
            options.hash = options.hash + '/tag';
        }

        this.render();
        return this;
    },

    render : function() {
        var tags = '';
        var self = this;
        if(this.collection) {
            _(this.collection.models).each(function(tag){
                tags += self.tagTemplate({
                    model : tag,
                    hash : self.options.hash
                });
            });
        }

        var out = this.template({
            tags : tags || 'Loading...'
        });
        $(this.el).html(out).find('.content').hide().find('a[href="' + window.location.hash + '"]').each(function(){
            $(this).addClass('cloud-highlight');
        });

        return this;
    },

    toggleCloud : function(){
        var anchor = $(this.el).find('div:first-child');
        var content = $(this.el).find('.content');

        content.find('.toggle').each(function(){
            if($(this).hasClass('cloud-highlight')) {
                $(this).removeClass('cloud-highlight');
            } else {
                $(this).addClass('cloud-highlight');
            }
        });

        var anchorHeight = anchor.height();
        var windowHeight = $(window).height();
        var contentHeight = content.height();
        var contentPaddingTop = parseInt(content.css('padding-top')) || 0;
        var contentPaddingBottom = parseInt(content.css('padding-bottom')) || 0;
        var contentMarginTop = parseInt(content.css('margin-top')) || 0;
        var contentMarginBottom = parseInt(content.css('margin-bottom')) || 0;
        var contentBorderTop = parseInt(content.css('border-top')) || 0;
        var contentBorderBottom = parseInt(content.css('border-bottom')) || 0;
        
        if(contentHeight >
            (windowHeight - anchorHeight - contentPaddingTop - contentPaddingBottom -
             contentMarginTop - contentMarginBottom - contentBorderTop - contentBorderBottom)) {
            content.addClass('internalscroll');
            content.height(
                windowHeight - anchorHeight - contentPaddingTop - contentPaddingBottom -
                contentMarginTop - contentMarginBottom - contentBorderTop - contentBorderBottom -
                5
            );
        } else {
            content.removeClass('internalscroll');
            content.height('');
        }

        content.toggle();

        if(content.is(':visible')) {
            anchor.addClass('cloud-highlight');
        } else {
            anchor.removeClass('cloud-highlight');
        }
        
        return false;
    },

    loadTagPictures : function(event){
        $(this.el).find('a.cloud-highlight').each(function(){
            $(this).removeClass('cloud-highlight');
        });
        $(event.currentTarget).addClass('cloud-highlight');
        this.toggleCloud();
    }
});