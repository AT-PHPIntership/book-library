$(document).ready(function() {
  $('form').on('reset', function(e) {
    if ($(CKEDITOR.instances).length) {
      for (var key in CKEDITOR.instances) {
        var instance = CKEDITOR.instances[key];
        if ($(instance.element.$).closest('form').attr('name') == $(e.target).attr('name')) {
            instance.setData(instance.element.$.defaultValue);
        }
      }
    }
  });
  
  // change display image after select
  $('#image').change(function (){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#image-display')
          .attr('src', e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
      $('#image-display').show();
    }
  })
  //stop display image when press reset
  $('#btn-reset').click(function() {
    $('#image-display').attr('src', '').hide();
  })

  $('.btn-reset').click(function() {
    $('#image-db-display').show();
    $('#image-display').hide();
  });

  $('.image-edit').change(function (){
    $('#image-display').show();
    $('#image-db-display').hide();
  })

  //datapicker option
  $('.date-own').datepicker({
    viewMode: "years", 
    minViewMode: 2,
    autoclose: true,
    format: 'yyyy',
  });
});

$(window).on('load', function(){
  $('#image').val('');
});

$(window).on('load', function(){
  $('.alert').delay(5000).slideUp(400);
});
