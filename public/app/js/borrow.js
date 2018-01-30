$('.btn-check').click(function () {
  $id = $(this).attr('id');
  $('#loading').hide();
})
$('.btn-confirm').click(function () {
  $('#form-confirm-'+$id).submit();
  $('#loading').show()
})
