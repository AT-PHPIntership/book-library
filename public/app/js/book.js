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
        console.log('delete book ' +$id);
        removeEventForAllButton();
        console.log('turn off event delete');
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
                console.log('turn on event restore');
                console.log($data);
                console.log('---------------------------------------');
            }
        });
    }

    var restoreBook = function($id) {
        console.log('restore book ' +$id);
        removeEventForAllButton();
        // $($element).prop("onclick", null).off('click');
        console.log('turn off event restore');
        $.ajax({
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $token },
            url: '/api/books/' + $id + '/restore',
            data:{
            },
            success: function ($data) {
                setBackGroundAndIcon($id);
                addEventForAllButton();
                console.log('turn on event delete');
                console.log('---------------------------------------');
            }
        }); 
    }

    var setBackGroundAndIcon = function($id) {
        $icon = $('i[book-id=' + $id + ']');
        $bookInfo = $icon.parent().parent();
        console.log($icon.attr('class').indexOf('fa-trash-o'));
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
        console.log('change UI');
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
