$(function () {

  "use strict";
  $(window).load(function() {
    $('#loading').fadeOut('slow', function() {
      $(this).remove();
    });
  })
  
  $('input.checkbox').iCheck({
    checkboxClass: 'icheckbox_minimal-blue'
  });

  $('input.checkbox-all').on('ifChanged', function() {
    var checked = $(this).is(':checked');

    var $table = $(this).closest('table');
    $table.find('tbody td .checkbox').each(function() {
      if (checked) {
        $(this).iCheck('check');
      } else {
        $(this).iCheck('uncheck');
      }
    });
  });

});
