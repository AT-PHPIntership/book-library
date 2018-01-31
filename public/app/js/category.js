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
        $('#myModal').modal('show');
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
          $("#myModal").modal("hide");
        },
        error: function(error) {
          errorText = JSON.parse(error.responseText);
          $('.errors').html(errorText.errors.name);
        }
      });
    });

    $('.btn-close-update-category').on('click', function () {
      $('.errors').html("");
    });
  }
  // Prototype
  category.prototype = {
    constructor: category,
    editNameCategory: editNameCategory,
    updateNameCategory: updateNameCategory
  }
  // Return category;
  return category;
})();

var newCategory = new category();
