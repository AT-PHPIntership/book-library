$(document).ready(function() {
  $(document).on('click', '.btn-show-edit-modal', function() {
    $('#idCategory').val($(this).attr('data-id'));
    $('#nameCategory').val($(this).attr('data-name'));
    $('#myModal').modal('show');
  });
  $('.modal-footer').on('click', '.editCategory', function() { 
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
});
