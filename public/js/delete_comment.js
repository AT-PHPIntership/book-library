
// Object
var comment = (function() {
    // Constructor
    var comment = function() {
    }
    // Methods
    var deleteComment = function() {
        var $id = '';
        $('.confirm-delete').on('click', function(e) {
            e.preventDefault();
            $id = $(this).data('id');
        });

        $('#btn-ok').click(function() {
            token = $('meta[name="csrf_token"]').attr('content');
            $.ajax({
                url: '/admin/comments/' + $id,
                type : 'DELETE',
                headers: { 'X-CSRF-TOKEN': token },
                data : {
                    id : $id,
                },
                success: function(data) {
                    if (data == 204){
                        $('[data-id=' + $id + ']').parent().parent().parent().parent().remove();
                        $('[data-id=' + $id + ']').parent().parent().remove();
                        messageSuccess();
                    } else {
                        messageFail();
                    }
                }
            });
        });

        function messageSuccess() {
            $('#message').html('').show();
            $('#message').append('<div class="alert alert-success"><strong>Success!</strong> Delete Comments</div>').fadeOut(5000);
        }
        function messageFail() {
            $('#message').append('<div class="alert alert-danger"><strong>Fail!</strong> Delete Comments</div>').fadeOut(5000);
        }
    }
    // Prototype
    comment.prototype = {
      constructor: comment,
      deleteComment: deleteComment
    }
    // Return user;
    return comment;
})();
var newComment = new comment();
