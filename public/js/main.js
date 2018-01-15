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
});
