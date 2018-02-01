// Constant
const $token = $('meta[name="csrf_token"]').attr('content');
const $colorGray = "rgb(221, 221, 221)";

// Object
var book = (function(){

    // Constructor
    var book = function(){
    }

    // Methods
    var addEventForAllButton = function() {
        $('.fa-trash-o').on('click', function () {
            let $id = $(this).attr('book-id');
            deleteBook($id);
        });
        $('.fa-history').on('click', function () {
            let $id = $(this).attr('book-id');
            restoreBook($id);
        });
    }

    var removeEventForAllButton = function() {
        $('.fa-trash-o').prop("onclick", null).off('click');
        $('.fa-history').prop("onclick", null).off('click');
    }

    var deleteBook = function($id) {
        removeEventForAllButton();
        $.ajax({
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $token },
            url: '/api/books/' + $id,
            data:{
                _method: 'delete',
            },
            success: function ($data) {
                setBackGroundAndIcon($id);
                addEventForAllButton();        
            }
        });
    }

    var restoreBook = function($id) {
        removeEventForAllButton();
        $.ajax({
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $token },
            url: '/api/books/' + $id + '/restore',
            data:{
            },
            success: function ($data) {
                setBackGroundAndIcon($id);
                addEventForAllButton();
            }
        }); 
    }

    var setBackGroundAndIcon = function($id) {
        $icon = $('i[book-id=' + $id + ']');
        $bookInfo = $icon.parent().parent();
        if ($icon.attr('class').indexOf('fa-trash-o') !== -1) {
            $icon.removeClass('fa-trash-o btn-danger');
            $icon.addClass('fa-history btn-info');
            $('.btn-edit-' + $id).attr('disabled','disabled');
            $bookInfo.css("background-color", $colorGray);
        } else {
            $('btn-edit-' + $id).removeAttr('disabled');
            $bookInfo.css("background-color", "white");
            $icon.removeClass('fa-history btn-info');
            $icon.addClass('fa-trash-o btn-danger');
            $('.btn-edit-' + $id).removeAttr('disabled');
        }
    }

    // Prototype
    book.prototype = {
        constructor: book,
        addEventForAllButton: addEventForAllButton,
        removeEventForAllButton: removeEventForAllButton,
        deleteBook: deleteBook,
        restoreBook: restoreBook,
        setBackGroundAndIcon: setBackGroundAndIcon
    }

    // Return book
    return book;
})();

var $newBook = new book();
