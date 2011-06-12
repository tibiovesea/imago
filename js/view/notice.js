App.Views.Notice = Backbone.View.extend({
    el : $('#notice'),

    className: "success",
    displayLength: 5000,
    defaultMessage: '',

    initialize: function() {
        _.bindAll(this, 'render');
        this.message = this.options.message || this.defaultMessage;
        this.render();
    },

    render: function() {
        var view = this;

        var message = this.message;
        if(this.options.details) {
            message += '<div>' + this.options.details + '</div>';
        }

        $(this.el).html($('<div>').addClass('error').html(message));

        $.doTimeout(this.displayLength, function() {
            $(view.el).hide();
            $.doTimeout(2000, function() {
                view.remove();
            });
        });

        return this;
    }
});