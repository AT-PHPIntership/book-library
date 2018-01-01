$(document).ready(function() {
  /**
   * show editor
   */
  $(function () {
    CKEDITOR.replace('editor1')
    $('.textarea').wysihtml5()
  })
  /**
   * show submit button when input file has value
   */
  $('#btn-import-excel').change(function(){
    $('#btn-submit-file').show();
  });

  function checkFileValue() {
    if($('#btn-import-excel').val() !== null) {
      $('#btn-submit-file').show();
    }
  }
  checkFileValue();
})
