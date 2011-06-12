App.Controllers.Picture = Backbone.Controller.extend({
    routes : {
        '' :                            'list',
        'picture' :                     'list',
        'picture/p:page' :              'list',
        'picture/tag/:tag' :            'listByTag',
        'picture/tag/:tag/p:page' :     'listByTag',
        'picture/tag/:tag/:id' :        'showSingleFromTag'
    },

    baseHash : '#picture',

    commentList : null,

    tagPrefix : '/tag',
    paginationPrefix : '/p',

    initialize : function(optoins) {
        var self = this;
        this.route(/picture\/([a-z0-9]{8})/, 'showSingle', function(id){
            self.showSingle(id);
        });
    },

    showSingleFromTag : function(tag, id) {
        if(this._validId(id)) {
            this._fetchPicture(tag, id);
            this._fetchComments(id);
        } else {
            window.location.hash = this.baseHash + this.tagPrefix + '/' + tag;
        }
    },

    showSingle : function(id) {
        if(this._validId(id)) {
            this._fetchPicture(null, id);
            this._fetchComments(id);
        }else {
            window.location.hash = this.baseHash;
        }
    },

    list : function(page) {
        var self = this;
        var pictures = new App.Collections.Picture(undefined, {page : page});
        var breadcrumbs = new App.Collections.Breadcrumbs();
        var view;
        
        pictures.fetch({
            success : function(model, response) {
                view = new App.Views.PictureList({collection : model});
                new App.Views.Pagination({collection : model});

                breadcrumbs.add({baseHash : pictures.baseHash, name : view.className});
                if(page) {
                    breadcrumbs.add({baseHash : pictures.baseHash, name : 'page ' + page, hrefParts : [page]});
                }
                self.trigger('updateView', {breadcrumbs : breadcrumbs});
            },
            error : function(model, response) {
                new App.Views.Error({
                    message : 'Error loading pictures for page "' + page + '"',
                    details : response.responseText
                });
                window.location.hash = self.baseHash;
            }
        });

        this._removeComments();

        this.trigger('updateView', {baseHash : pictures.baseHash, breadcrumbs : [page]});
    },

    listByTag : function(tag, page) {
        if(page !== undefined && page !== null && !this._validPage(page)) {
            window.location.hash = this.baseHash + (tag ? this.tagPrefix + '/' + tag : '');
            return;
        }
        
        var pictures = new App.Collections.Picture(undefined, {tag : tag, page : page});
        var breadcrumbs = new App.Collections.Breadcrumbs();
        var view;

        var self = this;
        pictures.fetch({
            success : function(model, resource) {
                view = new App.Views.PictureList({collection : model});
                new App.Views.Pagination({collection : model});

                breadcrumbs.add({baseHash : pictures.baseHash, name : view.className});
                if(tag) {
                    breadcrumbs.add({baseHash : pictures.baseHash, name : tag, hrefParts : [self.tagPrefix.substring(1), tag]});
                }
                if(page) {
                    var hrefParts = [];
                    if(tag) {
                        hrefParts.push(self.tagPrefix.substring(1));
                        hrefParts.push(tag);
                    }
                    hrefParts.push(page);
                    breadcrumbs.add({baseHash : pictures.baseHash, name : 'page ' + page, hrefParts : hrefParts});
                }

                self.trigger('updateView', {breadcrumbs : breadcrumbs});
            },
            error : function(model, response) {
                new App.Views.Error({
                    message : 'error loading pictures for tag "' + tag + '" and page "' + page + '"',
                    details : response.responseText
                });
                window.location.hash = pictures.baseHash + (tag ? self.tagPrefix + '/' + tag : '') + (page ? self.pagePrefix + page : '');
            }
        });

        this._removeComments();

        this.trigger('updateView', {baseHash : pictures.baseHash, breadcrumbs : [self.tagPrefix.substring(1), tag, page]});
    },

    _validPage : function(page) {
        var message = 'page is invalid';

        if(!(page >= 0)) {
            new App.Views.Error({message : message});
            return false;
        }
        return true;
    },

    _validId : function(id) {
        var message = 'Could not find that picture';

        if(!id.match(/^[a-z0-9]{8}$/)) {
            new App.Views.Error({message : message});
            return false;
        }

        return true;
    },

    _fetchPicture : function(tag, id) {
        var self = this;
        var picture = new App.Models.Picture({id : id, tag : tag});
        var breadcrumbs = new App.Collections.Breadcrumbs();
        var view;

        picture.fetch({
            success : function(model, response) {

                view = new App.Views.Picture({model : model});

                breadcrumbs.add({baseHash : picture.baseHash, name : view.className});
                if(tag) {
                    breadcrumbs.add({baseHash : picture.baseHash, name : tag, hrefParts : [self.tagPrefix.substring(1), tag]});
                }
                breadcrumbs.add({baseHash : picture.baseHash, name : picture.get('fileName'), hrefParts : [self.tagPrefix.substring(1), tag, id]});
            
                self.trigger('updateView', {breadcrumbs : breadcrumbs});
            
            },
            error : function(model, response) {
                new App.Views.Error({message : 'Could not find that picture'});
                window.location.hash = self.baseHash + (tag ? self.tagPrefix + '/' + tag : '');
            }
        });
    },

    _fetchComments : function(id) {
        var self = this;
        var comments = new App.Collections.Comment();
        comments.picture = id;
        comments.fetch({
            success : function(model, response) {
                self.commentList = new App.Views.CommentList({collection : model});
            },
            error : function(model, response) {
                new App.Views.Error({
                    message : 'Could not load picture comments',
                    details : response.responseText
                })
            }
        });
    },

    _removeComments : function() {
        if(this.commentList) {
            this.commentList.remove();
        }
    },

    _createBreadcrumbs : function(baseHash, name, hrefParts) {
        return new App.Models.Breadcrumbs({
            baseHash : baseHash,
            name : name,
            hrefParts : hrefParts
        });
    }
});