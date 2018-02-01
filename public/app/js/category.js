// Category Object 
var category = (function(){
  // Constructor
  var category = function(){
  }
  // edit name of category method
  var editNameCategory = function() {
    classBtnEditNameCategories = document.getElementsByClassName('btn-show-edit-modal');
    for (let classBtnEditNameCategory of classBtnEditNameCategories) {
      classBtnEditNameCategory.addEventListener('click', function () {
        $('#idCategory').val($(this).attr('data-id'));
        $('#nameCategory').val($(this).attr('data-name'));
      });
    }
  }
  // update name of category method to database
  var updateNameCategory = function() {
    $('.btn-UpdateNameCategory').on('click', function () {
      token = $('meta[name="csrf_token"]').attr('content');
      id = $("#idCategory").val();
      name = $('#nameCategory').val();
      $.ajax({
        type: 'PUT',
        headers: { 'X-CSRF-TOKEN': token },
        url: '/admin/categories/' + id,
        data: {
          'name': name
        },
        success: function(request) {
          $("#nameCategory" + id).html(request.name);
          $('#edit-modal' + id).attr('data-name', request.name);
        },
        error: function() {
          alert("Error, please try again.");
        }
      });
    });
  }

  //loading page with out refresh when deleted category
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
    editNameCategory: editNameCategory,
    updateNameCategory: updateNameCategory,
    loadPage: loadPage
  }
  // Return category;
  return category;
})();

var newCategory = new category();
