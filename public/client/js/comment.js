$(document).ready(function () {
    $('.comment-container').delegate('.reply','click',function() {
        var commentId = $(this).data('comment-id');
        var userId = $(this).data('user-id');
        var form = `
        <form method='POST' class='mt-2' action='${createReplyRoute}'>
            <input type='hidden' name='_token' value='${csrfToken}'>
            <input type='hidden' name='commentId' value='${commentId}'>
            <input type='hidden' name='userId' value='${userId}' />
            <div class='col-lg-12'>
                <textarea cols='60' rows='4' class='form-control mb-10' id='message' name='content' placeholder='Enter reply' required></textarea>
            </div>
            <button type='submit' class='btn btn-success ml-3'>Reply</button>
            <button type='button' class='btn btn-danger cancel-btn'>Cancel</button>
        </form>`;
        console.log("WORKING");
        $(this).parent().find('.reply-form').html(form);
    });
    $('.comment-container').delegate('.cancel-btn','click',function(){
        $(this).parent().parent().parent().find('.reply-form').empty();
    });

    $('.comment-container').delegate('.cancel-btn','click',function(){
        $(this).parent().parent().parent().find('.reply-form').empty();
    });

    $('.comment-container').delegate('.reply-to-reply','click',function(){
        var commentId = $(this).data('comment-id');
        var userId = $(this).data('user-id');
        var form = `
        <form method='POST' cs='mt-2' action='${createReplyRoute}'>
            <input type='hidden' name='_token' value='${csrfToken}'>
            <input type='hidden' name='commentId' value='${commentId}'>
            <input type='hidden' name='userId' value='${userId}' />
            <div class='col-lg-12'>
                <textarea cols='60' rows='4' class='form-control mb-10' name='content' placeholder='Enter reply' required></textarea>
            </div>
            <button type='submit' class='btn btn-success ml-3'>Reply</button>
            <button type='button' class='btn btn-danger cancel-btn'>Cancel</button>
        </form>
        `;
        $(this).parent().find('.reply-to-reply-form').html(form);
    });
});;