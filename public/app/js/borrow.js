$('.btn-check').click(function () {
  $dataAction = $(this).attr('data-action');
  $dataName = $(this).attr('data-name');
  $('.data-content').html($dataName);
})
$('.btn-confirm').click(function () {
  $('#form-confirm').attr('action', $dataAction);
  $('#form-confirm').submit();
})
