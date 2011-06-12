App.Controllers.PictureUpload = Backbone.Controller.extend({
    routes : {
        'picture/upload' : 'upload'
    },

    upload : function() {
        new App.Views.PictureUpload();
    }
});