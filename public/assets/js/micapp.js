
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
  reloadPage: function(target) {
    if (typeof target == 'undefined') {
      target = '_blank';
    }

    if (target == '_blank') {
      window.location.reload(false); 
    } else if (target == '_parent') {
      parent.location.reload(false);
    }
  }, 

};


$(function () {
  "use strict";
  
});
