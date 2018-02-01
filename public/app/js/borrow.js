$('.btn-check').click(function () {
  $dataAction = $(this).attr('data-action');
})
$('.btn-confirm').click(function () {
  $('#form-confirm').attr('action', $dataAction);
  $('#form-confirm').submit();
})
