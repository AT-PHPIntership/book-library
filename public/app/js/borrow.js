$('.btn-check').click(function () {
  $id = $(this).attr('id');
})
$('.btn-confirm').click(function () {
  $('#form-confirm-'+$id).submit();
})
