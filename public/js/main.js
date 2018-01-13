$(document).ready(function() {
  // change display image after select
  $('#image').change(function (){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#image-display')
          .attr('src', e.target.result)
          .width(150)
          .height(200);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
  //stop display image when press reset
  $('#btn-reset').click(function() {
    $('#image-display').attr('src', '');
  })
});
