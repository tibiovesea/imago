<script type='text/template' id='comment-form-template'>
    <div class="comment-form-wrapper">
        <div id='comment-notice'></div>
        <form id="new-comment">
            <div class="form-item">
                <label>name:</label>
                <input type="text" name="name" class="form-input" value="" maxlength='64'>
            </div>
            <div class="form-item">
                <label>comment:</label>
                <textarea type="text" name="comment"></textarea>
            </div>
            <div class="form-item d-none">
                <label>dont fill in:</label>
                <input type="text" name="req">
            </div>
            <div class="form-item submit-button-wrapper">
                <button class="submit-button">post comment</button>
            </div>
        </form>
    </div>
</script>