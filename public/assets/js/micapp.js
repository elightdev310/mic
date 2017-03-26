
var MICApp = {};

MICApp.UI = {
  refreshUserNotifyCount: function ($count) {
    $('.notifications-menu a.user-notify-link span.label').html($count);
    if ($count) {
      $('.notifications-menu a.user-notify-link span.label').removeClass('hidden');
    } else {
      $('.notifications-menu a.user-notify-link span.label').addClass('hidden');
    }
  }, 
};


$(function () {
  "use strict";
  
});
