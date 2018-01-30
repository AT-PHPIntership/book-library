$(document).ready(function() {
  $(document).on('click', '.edit-modal', function() {
    $('#idCategory').val($(this).data('id'));
    $('#nameCategory').val($(this).attr('data-name'));
    $('#myModal').modal('show');
  });

  $('.modal-footer').on('click', '.editCategory', function() { 
    token = $('meta[name="csrf_token"]').attr('content');
    $.ajax({
          type: 'PUT',
          headers: { 'X-CSRF-TOKEN': token },
          url: '/admin/categories/' + $("#idCategory").val(),
          data: {
            'id': $("#idCategory").val(),
            'name': $('#nameCategory').val()
          },
          success: function(data) {
            $("#nameCategory" + data.id).html(data.name);
            $('#edit-modal').attr('data-name',data.name);
            $("#myModal").modal("hide");
          },
          error: function(error) {
            obj = JSON.parse(error.responseText);
            $('.errors').html(obj.errors.name);
          }
    });
  });
});
