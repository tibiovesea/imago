var App = {
    Views : {},
    Models : {},
    Controllers : {},
    Collections : {},
    init : function() {
        new App.Controllers.Header();
        Backbone.history.start();
    }
};

$(function(){
    App.init();
});