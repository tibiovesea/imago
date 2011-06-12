App.Collections.Picture = Backbone.Collection.extend({
    model : App.Models.Picture,

    tagPrefix : '/tag',
    paginationPrefix : '/p',

    initialize : function(model, args) {
        this.page = args && args.page ? args.page : 0;
        this.tag = args && args.tag ? args.tag : undefined;
    },

    baseUrl : '?api=picture',
    url : function() {
        var tagPart = this.tag ? this.tagPrefix + '/' + this.tag : '';
        var pagePart = this.page ? this.paginationPrefix + this.page : '';

        return this.baseUrl + tagPart + pagePart;
    },

    baseHash : '#picture',
    hash : function(includePagination) {
        var tagPart = this.tag ? this.tagPrefix + '/' + this.tag : '';
        var pagePart = this.page && includePagination !== false ? this.paginationPrefix + this.page : '';

        return this.baseHash + tagPart + pagePart;
    },

    parse : function(response) {
        this.page = response.page;
        this.pageSize = response.pageSize;
        this.pageTotal = response.pageTotal;
        return response.picture;
    },

    nextPage : function() {
        if(this.pageTotal > 1 && this.page + 1 < this.pageTotal) {
            return this.page + 1;
        }
        return this.page;
    },

    previousPage : function() {
        if(this.page - 1 >= 0) {
            return this.page - 1;
        }
        return this.page;
    }
});