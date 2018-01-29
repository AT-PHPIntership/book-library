// Object
var category = (function(){
  
    // Constructor
    var category = function(){
    }
    
    // Methods
    var unloadPage = function(url, page, deleteMessage, totalCategories = null) {
        $('.delete-category').click(function() {
            $('.confirm').attr('data-id', $(this).attr('id'));
            $(this).parent().find('.delete-progress').attr('id', 'active-progress');
        });

        if (totalCategories != null) {
            $('#total-categories').text(totalCategories);
        } else {
            $('#total-categories').text($('#total-categories').text());
        }

        window.history.pushState("string", "Category", url);

        $('.confirm').click(function() {
            id = $(this).attr('data-id');
            url = '/admin/categories/' + id;
            $('#active-progress').css('display', 'inline-block');
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
                        console.log(data);
                        displayMessage(deleteMessage, 'alert-success');
                        $('#unload-paginate').html(data);
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
      unloadPage: unloadPage
    }
  
    // Return category;
    return category;
  })();
  
  var category = new category();
