App.Views.CommentList = Backbone.View.extend({
    el : $('#comment'),
    
    template : _.template($('#comment-list-template').html()),
    commentFormTemplate : _.template($('#comment-form-template').html()),
    
    className : 'comment',

    events : {
        'click .submit-button' : 'newComment'
    },
    
    initialize : function() {
        _.bindAll(this, 'render', 'remove', 'newComment');
        this.collection.bind('add', this.render);
        
        this.render();

        return this;
    },

    render : function() {
        var out = '';
        var self = this;
        
        if(this.collection && this.collection.models) {
            out = this._commentHeader();
            _(this.collection.models).each(function(item){
                out += self.template(item);
            });
        }

        out += this.commentFormTemplate();
        
        $(this.el).html(out);

        //must be here because comment DIV is part of the SINGLE picture template
        //should probably take it out and just clear when non-single picture is set
        $('#comment').html(out);

        return this;
    },

    _commentHeader : function() {
        var header = _.template('<div id="comment-list-header">comments</div>');
        return header();
    },

    remove : function() {
        $(this.el).html('');
    },

    newComment : function(event) {
        var self = this;
        var form = $(event.currentTarget).parents('form');
        
        var pName = form.find('[name=name]').val();
        var pComment = form.find('[name=comment]').val();
        var pReq = form.find('[name=req]').val();

        if(!_(pName).trim()) {
            new App.Views.Error({
                message : 'name must be entered to submit a comment'
            });
            return false;
        }
        if(!_(pComment).trim()) {
            new App.Views.Error({
                message : 'cannot submit an empty comment'
            });
            return false;
        }

        var model = new App.Models.Comment();
        model.save({
            target : this.collection.picture,
            name : pName,
            comment : pComment,
            req : pReq
        },
        {
            success : function(model, response) {
                self.collection.add(model);
            },
            error : function(model, response) {
                new App.Views.Error({
                    message : response.responseText
                });
            }
        });
        
        return false;
    },

    _clearForm : function(target) {
        $(':input', target)
            .not(':button, :submit, :reset, :hidden')
            .val('');
    }
});