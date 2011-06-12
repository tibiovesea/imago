<script type='text/template' id='picture-list-template'>
    <div class='picture-wrapper'>
        <div class="picture-frame-wrapper">
            <div class='picture-frame outer-wrapper'>
                <div class='picture middle-wrapper'>
                    <div class='picture-inner-wrapper'>
                        <a href='<%= model.hash() %>'>
                            <img src="<%= model.get('thumbPath') %>"/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="picture-info-wrapper">
                <div class='picture-info'>
                    <span class='picture-title'><%= model.get('fileName') %></span>
                </div>
                <div class='picture-info'>
                    <span class='picture-info'><%= model.get('date') %></span>
                </div>
                <div class='picture-info'>
                    <a href='<%= model.hash() %>' class='picture-comments-link'><span class='picture-info'><%= model.get('numComments') %> comments</span></a>
                </div>
            </div>
        </div>
    </div>
</script>