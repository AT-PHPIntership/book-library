// Object
var category = (function(){
  
  // Constructor
  var category = function(){
  }
    
  // Methods
  var loadPage = function(url, page, deleteMessage) {
    $('.delete-category').click(function() {
        $('.confirm').attr('data-id', $(this).attr('id'));
        $(this).parent().find('.delete-progress').attr('id', 'active-delete-progress');
    });

    window.history.replaceState("category", "Category", url);

    $('.confirm').click(function() {
      id = $(this).attr('data-id');
      url = '/admin/categories/' + id;
      $('#active-delete-progress').css('display', 'inline-block');
      $.ajax({
        url: url,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          _method: 'delete',
          "page": page,
        },
        success: function(data) {
          if (typeof(data) == 'object') {
              displayMessage(data.message, 'alert-danger');
          } else {
              displayMessage(deleteMessage, 'alert-success');
              $('#load-paginate').html(data);
              $('#total-categories').text($('#total-categories').text() - 1);
          }
          $('.delete-progress').attr('id', '').css('display', 'none');
        }
      });
    });
    
    function displayMessage(content, type)
    {
      $('#category-delete-message').html(content)
                                    .attr('class', 'alert ' + type)
                                    .show()
                                    .delay(5000)
                                    .slideUp(300);
    }
  }
  
    // Prototype
    category.prototype = {
      constructor: category,
      loadPage: loadPage
    }
  
    // Return category;
    return category;
  })();
  
  var category = new category();
