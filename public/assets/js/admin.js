/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  "use strict";

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
