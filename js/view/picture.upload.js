App.Views.PictureUpload = Backbone.View.extend({
    el : $('#gallery'),

    template :  _.template($('#upload-template').html()),

    events : {
        'change #file-upload' : '_fileSelect'
    },

    initialize : function() {
        _.bindAll(this, 'render');

        this.render();

        return this;
    },

    render : function() {
        var self = this;
        var out = self.template();
        this.el.html(out);
        return this;
    },

    _fileSelect : function(event) {
        event.stopPropagation();
        event.preventDefault();

        var out = '';

        var files = event.target.files;

        _(files).each(function(file){
            if(file.type.match('image\/.*')) {
                var reader = new FileReader();

                reader.onload = (function(currentFile){
                    return function(e) {
                        var img = $('<img>')
                            .addClass('thumb')
                            .attr('src', e.target.result)
                            .css('height', '100');
                        var span = $('<div>').html(img);
                        $('#file-list').append(span);

                        var xmpStart = e.target.result.match(/<x:xmpmeta.*/);
                        var xmpEnd = e.target.result.match(/<\/x:xmpmeta>/);
                        var xmpAll = e.target.result.substring(xmpStart.index, xmpEnd.index + xmpEnd[0].length);
                        var xmpXml = $.parseXML(xmpAll);
                        $(xmpXml).find('[nodeName="dc:subject"] [nodeName="rdf:Bag"] [nodeName="rdf:li"]').each(function(){
                            console.log($(this).text());
                        });
                        console.log(e.target);
                    };
                })(file);

                reader.readAsText(file);
            }
        });
        
        return false;
    }
});