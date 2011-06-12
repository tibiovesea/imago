App.Models.Picture = Backbone.Model.extend({
    tagPrefix : '/tag',
    
    baseUrl : '?api=picture',
    url : function() {
        var tagPart = '';
        if(this.attributes.tag) {
            tagPart = this.tagPrefix + '/' + this.attributes.tag;
        }
        var idPart = this.id ? '/' + this.id : '';

        return this.baseUrl + tagPart + idPart;
    },

    baseHash : '#picture',
    hash : function() {
        var tagPart = '';
        if(this.attributes.tag) {
            tagPart = this.tagPrefix + '/' + this.attributes.tag;
        }
        var idPart = this.id ? '/' + this.id : '';

        return this.baseHash + tagPart + idPart;
    }
});