App.Models.Comment = Backbone.Model.extend({
    baseUrl : '?api=picture',

    commentPrefix : '/comment',
    
    url : function() {
        var targetPart = '/' + this.attributes.target;
        var idPart = this.id ? '/' + this.id : '';

        var base =  this.baseUrl + targetPart + this.commentPrefix + idPart;
        return base;
    }
});